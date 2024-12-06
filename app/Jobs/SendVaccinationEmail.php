<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\VaccinationScheduled;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class SendVaccinationEmail implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    /**
     * Create a new job instance.
     */

    public $userId;

    public function __construct($user)
    {
        $this->userId = $user->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        if (!$user) {
            Log::error('User not found for ID: ' . $this->userId);
            return;
        }

        try {
            Mail::to($user->email)->send(new VaccinationScheduled($user));
            Log::info('Email sent to: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
        }
    }
}
