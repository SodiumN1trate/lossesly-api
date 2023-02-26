<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    use HasFactory,Filterable;

    protected $fillable = [
        'job_name',
        'job_description',
        'price',
        'user_id',
        'expert_id',
        'status_id',
        'started',
        'end',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expert() {
        return $this->belongsTo(User::class, 'expert_id');
    }
}
