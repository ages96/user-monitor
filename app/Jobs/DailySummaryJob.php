<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use App\Models\DailyRecord;
use App\Models\User;

class DailySummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Fetch counts from Redis
        $maleCount = Redis::get('male_count');
        $femaleCount = Redis::get('female_count');

        // If counts are null or zero, fetch from database
        if (!$maleCount) {
            $maleCount = User::where('gender', 'male')->count();
        }

        if (!$femaleCount) {
            $femaleCount = User::where('gender', 'female')->count();
        }

        // If average ages are null, calculate from database
        $maleAvgAge = User::where('gender', 'male')->avg('age') ?? 0;
        $femaleAvgAge = User::where('gender', 'female')->avg('age') ?? 0;

        // Create the daily record
        $dailyRecord = DailyRecord::create([
            'date' => date('Y-m-d'),
            'male_count' => $maleCount,
            'female_count' => $femaleCount,
            'male_avg_age' => $maleAvgAge,
            'female_avg_age' => $femaleAvgAge,
        ]);

        // Reset Redis counts and average ages for the next day
        Redis::set('male_count', 0);
        Redis::set('female_count', 0);
    }
}
