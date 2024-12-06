<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\VaccineCenter;

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
        Log::info('Vaccination scheduler started.');
        $today = now();
        if ($today->isWeekend()) {
            Log::info('Skipping schedule on weekend.');
            return;
        }

        VaccineCenter::each(function ($center) {
            Log::info("Processing center: {$center->name}");
            $users = User::where('status', 'not scheduled')
                ->where('vaccine_center_id', $center->id)
                ->orderBy('created_at')
                ->take($center->daily_limit)
                ->get();

            foreach ($users as $user) {
                Log::info("Scheduling user: {$user->email}");
                $user->update([
                    'status' => 'scheduled',
                    'scheduled_date' => now()->addDay(),
                ]);

                if (!$user) {
                    Log::error('Failed to dispatch email job: User is null.');
                    return;
                }

                Log::info('Dispatching email job for user: ' . $user->email);

                SendVaccinationEmail::dispatch($user);
            }
        });
    }
}
