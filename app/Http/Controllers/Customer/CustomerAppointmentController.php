<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// This controller is just for regular users/customers when they want to make or view their bookings!
class CustomerAppointmentController extends Controller
{
    protected $appointmentService;

    // Injecting the service so I don't write repeat code!
    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Show all appointments belonging to the logged-in customer.
     */
    public function index()
    {
        // Getting all the appointments for the current user and fetching the lawyer/slot details too so it's super fast!
        $appointments = Appointment::where('customer_id', Auth::id())
            ->with(['lawyer', 'slot'])
            ->latest() // Always put the newest ones first
            ->get();
            
        // Sending it all to the blade view!
        return view('customer.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form for a specific lawyer with their available slots.
     */
    public function create($lawyerId)
    {
        // Finding the lawyer they want to book, but only if they are approved by admins!
        $lawyer = Lawyer::where('status', 'approved')->findOrFail($lawyerId);
        
        // Fetching all the empty timeslots for this lawyer that haven't passed yet
        $availableSlots = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('is_booked', false) // Only empty ones!
            ->where('available_date', '>=', today()) // Don't show past days
            ->orderBy('available_date') // Sort by day
            ->orderBy('start_time') // Then sort by time
            ->get();
            
        return view('customer.appointments.create', compact('lawyer', 'availableSlots'));
    }

    /**
     * Save a new appointment and mark the selected slot as booked.
     * Uses database transaction with row-level locking to prevent double-booking.
     */
    public function store(Request $request)
    {
        // Making sure they filled out the required inputs properly
        $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'slot_id'   => 'required|exists:availability_slots,id',
            'subject'   => 'required|string|max:255',
            'meeting_place' => 'nullable|string|max:500', // Meeting place is optional!
        ]);

        $customerId = Auth::id(); // Get the logged-in user's ID
        $slotId = $request->slot_id;

        // I'm using a database transaction with lockForUpdate so if two people click book at the exact same millisecond, only one gets it!
        try {
            $appointment = DB::transaction(function () use ($slotId, $customerId, $request) {
                // Lock the row so nobody else can touch it until we're done
                $slot = AvailabilitySlot::lockForUpdate()->findOrFail($slotId);

                // If someone else already ninja-booked it right before us, throw an error
                if ($slot->is_booked) {
                    throw new \Exception('This time slot was just booked by another client. Please choose a different slot.');
                }

                // Making sure the lawyer is still approved just in case they got banned while we were on the page
                $lawyer = $slot->lawyer;
                if ($lawyer->status !== 'approved') {
                    throw new \Exception('This lawyer is not currently available for new bookings.');
                }

                // Actually saving the new appointment to the database
                $appointment = Appointment::create([
                    'customer_id'   => $customerId,
                    'lawyer_id'     => $lawyer->id,
                    'slot_id'       => $slot->id,
                    'subject'       => $request->subject,
                    'meeting_place' => $request->meeting_place,
                    'status'        => 'pending', // Starts off as pending until lawyer confirms!
                ]);

                // Update the slot so it doesn't show up in the dropdown for anyone else
                $slot->update(['is_booked' => true]);

                return $appointment;
            });
        } catch (\Exception $e) {
            // Uh oh, something broke, send them back with the error message
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Hooray! It worked
        return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked successfully.');
    }

    /**
     * Show a single appointment details.
     */
    public function show($id)
    {
        // Making sure they only look at their own appointment by checking the auth ID
        $appointment = Appointment::where('customer_id', Auth::id())
            ->with(['lawyer', 'slot'])
            ->findOrFail($id);

        return view('customer.appointments.show', compact('appointment'));
    }

    /**
     * Cancel an appointment and free the slot back to available.
     */
    public function destroy($id)
    {
        // Finding the appointment but again checking that it's theirs!
        $appointment = Appointment::where('customer_id', Auth::id())->findOrFail($id);

        // Deleting it through the appointmentService so it cleans up the availability slot too
        $this->appointmentService->delete($appointment);

        // Let them know it's gone
        return back()->with('success', 'Appointment cancelled.');
    }
}
