<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ActivateMemberships;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedule:work', function () {
    $schedule = app(Schedule::class);
    $schedule->command('memberships:activate')->daily();
})->purpose('Activate expired memberships automatically');
