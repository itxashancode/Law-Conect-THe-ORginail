<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lawyer_id',
        'available_date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    /**
     * Get the lawyer that owns the availability slot.
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }

    /**
     * Get the appointment associated with this slot.
     */
    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
