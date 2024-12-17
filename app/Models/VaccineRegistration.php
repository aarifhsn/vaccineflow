<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccineRegistration extends Model
{
    protected $fillable = [
        'name',
        'email',
        'nid',
        'phone',
        'password',
        'vaccine_center',
    ];
}
