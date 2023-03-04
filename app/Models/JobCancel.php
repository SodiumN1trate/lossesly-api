<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCancel extends Model
{
    protected $fillable = [
        'user_job_id',
        'reason',
    ];

    public function userJob(){
        return $this->belongsTo(UserJob::class, 'user_job_id');
    }


}
