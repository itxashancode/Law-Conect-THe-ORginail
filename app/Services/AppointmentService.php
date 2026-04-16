<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

// This service is basically where I put all the appointment logic so controllers aren't too messy!
class AppointmentService
{
    /**
     * Cancel an appointment and free up the associated availability slot.
     *
     * @param Appointment $appointment
     * @return bool
     */
    public function cancel(Appointment $appointment): bool
    {
        // I put this inside a DB transaction so if anything goes wrong, it undoes everything! Super safe.
        return DB::transaction(function () use ($appointment) {
            // First we gotta check if the appointment even has a slot attached to it
            // If it does, we need to make it available again by setting is_booked to false so someone else can book it!
            if ($appointment->slot) {
                $appointment->slot->update(['is_booked' => false]);
            }

            // If it's a customer cancelling, we might delete; 
            // if it's a lawyer/admin, we might just mark as cancelled.
            // Based on current controllers, some delete and some update.
            // Let's standardize to update status to 'cancelled' for records, 
            // unless the original logic specifically used delete().
            
            // Checking the controllers again:
            // AdminBookingController: delete()
            // CustomerAppointmentController: delete()
            // LawyerAppointmentController: update(['status' => 'cancelled'])
            
            // Just returning the updated appointment here, giving it the 'cancelled' status
            return $appointment->update(['status' => 'cancelled']);
        });
    }

    /**
     * Permanently remove an appointment and free the slot.
     *
     * @param Appointment $appointment
     * @return bool|null
     */
    public function delete(Appointment $appointment): ?bool
    {
        // Another database transaction here to keep it atomic (all or nothing)
        return DB::transaction(function () use ($appointment) {
            // Freeing up the slot again just like in the cancel function
            if ($appointment->slot) {
                $appointment->slot->update(['is_booked' => false]);
            }
            // Going ahead and completely wiping it from the database with delete()
            return $appointment->delete();
        });
    }

    /**
     * Confirm a pending appointment.
     *
     * @param Appointment $appointment
     * @return bool
     */
    public function confirm(Appointment $appointment): bool
    {
        // Gotta make sure we only confirm things that are pending right now
        // if it's already cancelled or confirmed, just bounce back a false
        if ($appointment->status !== 'pending') {
            return false;
        }

        // Updating the status to confirmed so they know it's a go!
        return $appointment->update(['status' => 'confirmed']);
    }
}
