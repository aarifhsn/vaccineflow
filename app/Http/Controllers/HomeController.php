<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        $notifiedAt = null;

        if (auth()->check()) {
            $authUser = auth()->user();
            $notifiedAt = $authUser->created_at->addHours(2)->timestamp;
        }

        return view('home', [
            'notifiedAt' => $notifiedAt
        ]);
    }
}
