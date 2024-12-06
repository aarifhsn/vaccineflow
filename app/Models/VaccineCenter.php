<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccineCenter extends Model
{
    /** @use HasFactory<\Database\Factories\VaccineCenterFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'daily_capacity',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'vaccine_center_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
