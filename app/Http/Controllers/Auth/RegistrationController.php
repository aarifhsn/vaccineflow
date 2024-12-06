<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\VaccineCenter;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index()
    {
        $vaccine_centers = VaccineCenter::all();

        return view('auth.registration', compact('vaccine_centers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nid' => 'required|numeric|unique:users,nid|digits:10',
            'phone' => 'required|unique:users|digits:11',
            'password' => 'required|confirmed|min:8',
            'vaccine_center' => 'required|exists:vaccine_centers,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nid' => $request->nid,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'vaccine_center_id' => $request->vaccine_center,
            'remember_token' => Str::random(10),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }
}
