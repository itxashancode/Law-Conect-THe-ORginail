<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'lawyer_id',
        'slot_id',
        'subject',
        'meeting_place',
        'status',
        'notes',
    ];

    /**
     * Get the customer who made the appointment.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the lawyer for this appointment.
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    /**
     * Get the availability slot for this appointment.
     */
    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }
}
