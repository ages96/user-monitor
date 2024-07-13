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
        $maleCountRedis = Redis::get('male_count');
        $femaleCountRedis = Redis::get('female_count');

        // Fetch counts from database
        $maleCountDB = User::where('gender', 'male')->count();
        $femaleCountDB = User::where('gender', 'female')->count();

        // Update Redis if counts are different
        if ($maleCountRedis != $maleCountDB) {
            Redis::set('male_count', $maleCountDB);
        }

        if ($femaleCountRedis != $femaleCountDB) {
            Redis::set('female_count', $femaleCountDB);
        }

        // Fetch average ages from Redis
        $maleAvgAgeRedis = Redis::get('male_avg_age');
        $femaleAvgAgeRedis = Redis::get('female_avg_age');

        // Fetch average ages from database
        $maleAvgAgeDB = User::where('gender', 'male')->avg('age') ?? 0;
        $femaleAvgAgeDB = User::where('gender', 'female')->avg('age') ?? 0;

        // Update Redis if average ages are different
        if ($maleAvgAgeRedis != $maleAvgAgeDB) {
            Redis::set('male_avg_age', $maleAvgAgeDB);
        }

        if ($femaleAvgAgeRedis != $femaleAvgAgeDB) {
            Redis::set('female_avg_age', $femaleAvgAgeDB);
        }

        // Create the daily record
        $dailyRecord = DailyRecord::create([
            'date' => now()->toDateString(),
            'male_count' => $maleCountDB,
            'female_count' => $femaleCountDB,
            'male_avg_age' => $maleAvgAgeDB,
            'female_avg_age' => $femaleAvgAgeDB,
        ]);

        // Reset Redis counts and average ages for the next day
        Redis::set('male_count', $maleCountDB);
        Redis::set('female_count', $femaleCountDB);
        Redis::set('male_avg_age', $maleAvgAgeDB);
        Redis::set('female_avg_age', $femaleAvgAgeDB);
    }
}
