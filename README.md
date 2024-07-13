# User Monitor System

## Overview

User Monitor System is developed using Laravel 11 on Ubuntu Linux. It includes two main pages: User Page and Daily Records Page. Additionally, it features a cron job for fetching users and a job for calculating average user age and gender counts.

## Pages

- **User Page**: Displays a list of users.
  - URL: [http://localhost:8000/users](http://localhost:8000/users)

- **Daily Records Page**: Shows daily records.
  - URL: [http://localhost:8000/daily-records](http://localhost:8000/daily-records)

## Cron Job

- **Fetch Users**: Implemented in `App\Console\Commands\FetchUsers.php`.
  - Fetches users from an external API and updates the database.
  - Scheduled to run hourly.

## Job

- **Daily Summary**: Handled by `App\Jobs\DailySummaryJob.php`.
  - Calculates average user age and counts male/female users daily.
  - Scheduled to run daily at 23:59.

## Schedule Configuration

Located in `routes/console.php`:

```php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

use App\Jobs\FetchUsersJob;
use App\Jobs\DailySummaryJob;

Artisan::command('daily:summary', function () {
    DailySummaryJob::dispatch();
})->purpose('Generate daily summary');

Schedule::command('fetch:users')->hourly();
Schedule::command('daily:summary')->dailyAt('23:59');
