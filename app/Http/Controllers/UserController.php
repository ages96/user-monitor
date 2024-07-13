<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyRecord;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all user records from the database
        $users = User::all();
        
        // Count the total number of users
        $userCount = User::count();

        // Return the view 'users.index' with the user data and count
        return view('users.index', compact('users', 'userCount'));
    }

    /**
     * Display a listing of daily records.
     *
     * @return \Illuminate\View\View
     */
    public function dailyRecords()
    {
        // Retrieve all daily records from the database
        $dailyRecords = DailyRecord::all();

        // Return the view 'users.daily_records' with the daily records data
        return view('users.daily_records', compact('dailyRecords'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($uuid)
    {
        // Find the user by UUID or fail with a 404 error if not found
        $user = User::findOrFail($uuid);
        
        // Delete the user record from the database
        $user->delete();

        // Redirect to the users index route
        return redirect()->route('users.index');
    }
}
