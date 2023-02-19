<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpeciality extends Model
{
    use HasFactory;

    protected $table = 'user_speciality';

    protected $fillable = [
        'user_id',
        'speciality_id',
        'experience',
    ];
}
