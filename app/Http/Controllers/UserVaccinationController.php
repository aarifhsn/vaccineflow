<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use App\Models\VaccineRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function handleWebhook(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:vaccine_registrations,email',
            'NID' => 'required|numeric|unique:vaccine_registrations,nid|digits:10',
            'Phone' => 'required|unique:vaccine_registrations|digits:11',
            'Password' => 'required|confirmed|min:8',
            'Vaccine_Center' => 'required|string',
        ]);

        // Register the user in the Vaccine system
        VaccineRegistration::create([
            'name' => $data['Name'],
            'email' => $data['Email'],
            'nid' => $data['NID'],
            'phone' => $data['Phone'],
            'password' => Hash::make($data['Password']),
            'vaccine_center' => $data['Vaccine_Center'],
        ]);

        // Respond to Zapier
        return response()->json(['success' => true, 'message' => 'User registered successfully.']);
    }
}
