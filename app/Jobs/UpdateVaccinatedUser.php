<?php

namespace App\Jobs;

use App\Enums\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UpdateVaccinatedUser implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vaccinatedUsers = User::where('status', UserStatus::VACCINATED)
            ->whereDate('scheduled_date', '<=', Carbon::now())
            ->get();

        foreach ($vaccinatedUsers as $user) {
            $user->status = UserStatus::VACCINATED;
            $user->save();
        }

        Log::info('Vaccinated users updated.');
    }
}
