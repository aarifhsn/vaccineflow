<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use App\Models\VaccineRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\VaccineCenter;

class UserVaccinationController extends Controller
{
    public function confirm(User $user)
    {
        if ($user->status === UserStatus::SCHEDULED) {
            $user->update(['status' => UserStatus::VACCINATED]);

            return response()->json([
                'success' => true,
                'message' => 'Vaccination confirmed successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User is not scheduled for vaccination.',
        ]);
    }
}
