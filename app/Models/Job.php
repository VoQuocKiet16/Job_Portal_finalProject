<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function jobType() {
        return $this->belongsTo(JobType::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function applications() {
        return $this->hasMany(JobApplication::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function relatedJobs() {
        return Job::where('status', 1)
                  ->where('id', '!=', $this->id)
                  ->where('category_id', $this->category_id)
                  ->limit(5)
                  ->get();
    }

    public function isFull()
    {
        return $this->applications->count() >= $this->vacancy;
    }
}