<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

use App\Jobs\FetchUsersJob;
use App\Jobs\DailySummaryJob;

// Registering an Artisan command 'daily:summary' to dispatch the DailySummaryJob
Artisan::command('daily:summary', function () {
    DailySummaryJob::dispatch();
})->purpose('Generate daily summary');

// Scheduling the 'fetch:users' command to run hourly
Schedule::command('fetch:users')->hourly();

// Scheduling the 'daily:summary' command to run daily at 23:59 (11:59 PM)
Schedule::command('daily:summary')->dailyAt('23:59');
