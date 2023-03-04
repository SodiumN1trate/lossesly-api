<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'speciality_id',
        'experience',
        'status',
        'user_id',
    ];

    public function speciality() {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    public function attachments() {
        return $this->belongsToMany(Attachment::class, 'attachment_specialist_application');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
