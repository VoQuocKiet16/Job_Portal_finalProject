<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function experience()
    {
        return $this->hasMany(Experience::class);
    }

    public function skill()
    {
        return $this->hasMany(Skill::class);
    }
}