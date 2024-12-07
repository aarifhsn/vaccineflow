<?php

use App\Jobs\ProcessVaccinationSchedule;
use App\Jobs\UpdateVaccinatedUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new ProcessVaccinationSchedule)
    ->dailyAt('21:00')
    ->timezone('Asia/Dhaka')
    ->withoutOverlapping();

Schedule::job(new UpdateVaccinatedUser)
    ->dailyAt('15:00')
    ->timezone('Asia/Dhaka')
    ->withoutOverlapping();
