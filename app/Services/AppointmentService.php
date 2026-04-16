<?php

namespace App\Services;

use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($appointment) {
            // Free up the slot if it exists
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
            
            // To maintain parity with existing behavior while centralizing:
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
        return DB::transaction(function () use ($appointment) {
            if ($appointment->slot) {
                $appointment->slot->update(['is_booked' => false]);
            }
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
        if ($appointment->status !== 'pending') {
            return false;
        }

        return $appointment->update(['status' => 'confirmed']);
    }
}
