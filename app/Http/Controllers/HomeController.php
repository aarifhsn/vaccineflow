<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $authUser->notifiedAt = $authUser->created_at->addHours(48);
        //$authUserTimeRemaining = now()->diffInHours($authUser->notifiedAt, true);

        return view('home', [
            'notifiedAt' => $authUser->notifiedAt->timestamp
        ]);
    }
}
