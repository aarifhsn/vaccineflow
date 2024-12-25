<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VaccineRegistration;
use App\Models\VaccineCenter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class WebhookFormController extends Controller
{
    public function handleWebhook(Request $request)
    {
        try {
            // Log or debug incoming data
            Log::info('Webhook payload:', $request->all());

            // Validate the incoming data
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'nid' => 'required|numeric|unique:users,nid|digits:10',
                'phone' => 'required|unique:users|digits:11',
                'password' => 'required|min:8',
                'vaccine_center' => 'required',
            ]);

            // Register the user in the Vaccine system
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'nid' => $data['nid'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'vaccine_center_id' => $data['vaccine_center'],
                'remember_token' => Str::random(10),
            ]);

            // Log or process the data
            Log::info('Webhook data received', $request->all());

            // Respond to Zapier
            return response()->json(['message' => 'User registered successfully.'], 201);

        } catch (ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            Log::error('Webhook error:', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
