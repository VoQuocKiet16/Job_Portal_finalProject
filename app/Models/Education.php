<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}