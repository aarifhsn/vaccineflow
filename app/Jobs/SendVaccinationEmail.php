<?php

namespace App\Jobs;

use App\Mail\VaccinationScheduled;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVaccinationEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $user;

    public function __construct(User $user)
    {
        if (! $user) {
            throw new \InvalidArgumentException('User cannot be null.');
        }
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if the user exists or scheduled_date is available.
        if (! $this->user || ! $this->user->scheduled_date) {
            Log::warning("User or scheduled_date not found for email: {$this->user->email}");

            return;
        }

        try {
            Mail::to($this->user->email)->send(new VaccinationScheduled($this->user));
            Log::info("Vaccination email sent to: {$this->user->email}");
        } catch (\Exception $e) {
            Log::error('Error sending vaccination email: '.$e->getMessage());
        }
    }
}
