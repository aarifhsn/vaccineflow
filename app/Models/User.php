<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nid',
        'phone',
        'vaccine_center_id',
        'remember_token',
        'status',
        'scheduled_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'scheduled_date' => 'date',
        ];
    }

    public function vaccineCenter()
    {
        return $this->belongsTo(VaccineCenter::class, 'vaccine_center_id');
    }

    public function getUsernameInitialsAttribute()
    {
        $UsernameParts = explode(' ', $this->name); // Split the name attribute by spaces
        $initials = '';

        foreach ($UsernameParts as $part) {
            $initials .= strtoupper($part[0]); // Get the first letter of each name part
        }

        // avatar url
        $initials = 'https://ui-avatars.com/api/?name=' . $initials . '&background=fff&color=1d4ed8&font-size=0.35&bold=true';

        return $initials;
    }
}
