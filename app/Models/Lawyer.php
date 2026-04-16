<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lawyer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'bar_license',
        'specialization',
        'city',
        'address',
        'phone',
        'bio',
        'photo',
        'experience_years',
        'consultation_fee',
        'status',
        'slug',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($lawyer) {
            if (empty($lawyer->slug)) {
                $lawyer->slug = Str::slug($lawyer->full_name . '-' . $lawyer->specialization . '-lawyer-' . $lawyer->city);
            }
        });
    }

    /**
     * Get the user that owns the lawyer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all availability slots for the lawyer.
     */
    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    /**
     * Get all appointments for the lawyer.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
