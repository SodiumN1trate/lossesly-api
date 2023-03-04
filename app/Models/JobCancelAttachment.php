<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCancelAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_cancel_id',
    ];
}
