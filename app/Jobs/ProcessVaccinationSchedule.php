<?php

namespace App\Jobs;

use App\Enums\UserStatus;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessVaccinationSchedule implements ShouldQueue
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
        VaccineCenter::each(function ($center) {
            // Calculate how many users are already scheduled for the current day
            $usersScheduledToday = User::where('vaccine_center_id', $center->id)
                ->whereDate('scheduled_date', Carbon::today())
                ->count();

            // Calculate how many users can be still be scheduled
            $remainingCapacity = $center->daily_capacity - $usersScheduledToday;

            if ($remainingCapacity <= 0) {
                Log::info("No more users to schedule for center: {$center->name}");

                return;
            }

            // Now, get the users who have not been scheduled, are eligible, and we can still schedule based on remaining capacity
            $users = User::where('status', UserStatus::NOT_SCHEDULED)
                ->where('vaccine_center_id', $center->id)
                ->whereDate('created_at', '<=', Carbon::now()->subDays(2))
                ->orderBy('created_at')
                ->limit($remainingCapacity)
                ->get();

            foreach ($users as $user) {
                $scheduledDate = now()->addDay();

                $user->update([
                    'status' => UserStatus::SCHEDULED,
                    'scheduled_date' => $scheduledDate,
                ]);

                Log::info("User scheduled: {$user->email}, scheduled_date: {$user->scheduled_date}");

                // Dispatch the email job
                SendVaccinationEmail::dispatch($user);
            }
        });
    }
}
