<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class FetchUsers extends Command
{
    // The name and signature of the console command.
    protected $signature = 'fetch:users';

    // The console command description.
    protected $description = 'Fetch users from the API and update the database';

    // Execute the console command.
    public function handle()
    {
        // Make a GET request to the API to fetch 20 random users
        $response = Http::get('https://randomuser.me/api/?results=20');
        
        // Decode the JSON response to get user data
        $users = $response->json()['results'];

        // Iterate through each user data from the API response
        foreach ($users as $userData) {
            // Update existing user or create a new user in the database
            // based on the unique uuid. If the uuid exists, update the user attributes.
            // Otherwise, create a new user record.
            User::updateOrCreate(
                ['uuid' => $userData['login']['uuid']],
                [
                    'name' => $userData['name']['first'] . ' ' . $userData['name']['last'],
                    'gender' => $userData['gender'],
                    'location' => $userData['location']['city'],
                    'age' => $userData['dob']['age']
                ]
            );
        }
    }
}
