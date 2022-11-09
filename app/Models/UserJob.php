<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    protected $fillable = [
        'user_id',
        'expert_id',
        'status_id',
        'started',
        'end',
    ];
}
