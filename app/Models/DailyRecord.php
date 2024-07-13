<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRecord extends Model
{
    // Define which attributes can be mass-assigned
    protected $fillable = ['date', 'male_count', 'female_count', 'male_avg_age', 'female_avg_age'];

    /**
     * Boot method for the model.
     * This method is called when the model is instantiated.
     */
    protected static function boot()
    {
        // Call the parent boot method
        parent::boot();

        // Add an event listener for the 'updated' event
        static::updated(function ($record) {
            // Call the calculateAverages method when the record is updated
            $record->calculateAverages();
        });
    }

    /**
     * Calculate the average age of male and female users.
     * This method is called whenever a DailyRecord is updated.
     */
    public function calculateAverages()
    {
        // Retrieve all male users
        $maleUsers = User::where('gender', 'male')->get();
        // Retrieve all female users
        $femaleUsers = User::where('gender', 'female')->get();

        // Calculate the average age of male users
        $this->male_avg_age = $maleUsers->avg('age');
        // Calculate the average age of female users
        $this->female_avg_age = $femaleUsers->avg('age');

        // Save the updated record
        $this->save();
    }
}
