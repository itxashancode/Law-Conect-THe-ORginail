<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerAppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(\App\Services\AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Show all appointments belonging to the logged-in customer.
     */
    public function index()
    {
        $appointments = Appointment::where('customer_id', Auth::id())
            ->with(['lawyer', 'slot'])
            ->latest()
            ->get();
        return view('customer.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form for a specific lawyer with their available slots.
     */
    public function create($lawyerId)
    {
        $lawyer = Lawyer::where('status', 'approved')->findOrFail($lawyerId);
        $availableSlots = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('is_booked', false)
            ->where('available_date', '>=', today())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();
        return view('customer.appointments.create', compact('lawyer', 'availableSlots'));
    }

    /**
     * Save a new appointment and mark the selected slot as booked.
     * Uses database transaction with row-level locking to prevent double-booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'slot_id'   => 'required|exists:availability_slots,id',
            'subject'   => 'required|string|max:255',
            'meeting_place' => 'nullable|string|max:500',
        ]);

        $customerId = Auth::id();
        $slotId = $request->slot_id;

        // Use transaction with pessimistic locking to prevent race conditions
        try {
            $appointment = DB::transaction(function () use ($slotId, $customerId, $request) {
                // Lock the slot row for update
                $slot = AvailabilitySlot::lockForUpdate()->findOrFail($slotId);

                // Check if slot is still available
                if ($slot->is_booked) {
                    throw new \Exception('This time slot was just booked by another client. Please choose a different slot.');
                }

                // Verify the slot belongs to an approved lawyer
                $lawyer = $slot->lawyer;
                if ($lawyer->status !== 'approved') {
                    throw new \Exception('This lawyer is not currently available for new bookings.');
                }

                // Create appointment
                $appointment = Appointment::create([
                    'customer_id'   => $customerId,
                    'lawyer_id'     => $lawyer->id,
                    'slot_id'       => $slot->id,
                    'subject'       => $request->subject,
                    'meeting_place' => $request->meeting_place,
                    'status'        => 'pending',
                ]);

                // Mark slot as booked
                $slot->update(['is_booked' => true]);

                return $appointment;
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked successfully.');
    }

    /**
     * Show a single appointment details.
     */
    public function show($id)
    {
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
        $appointment = Appointment::where('customer_id', Auth::id())->findOrFail($id);

        $this->appointmentService->delete($appointment);

        return back()->with('success', 'Appointment cancelled.');
    }
}
