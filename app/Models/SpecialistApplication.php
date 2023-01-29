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
    ];

    public function speciality() {
        return $this->belongsTo(Speciality::class);
    }

    public function attachments() {
        return $this->belongsToMany(Attachment::class, 'attachment_specialist_application');
    }
}
