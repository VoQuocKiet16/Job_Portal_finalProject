<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'requested_role', 'approved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
