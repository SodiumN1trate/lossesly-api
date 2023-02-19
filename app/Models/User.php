<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'avatar',
        'email',
        'birthday',
        'location',
        'about_me',
        'is_expert',
        'rating',
        'password',
        'gender_id',
    ];


    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function specialities(){
        return $this->belongsToMany(Speciality::class, 'user_speciality')->withPivot('price_per_hour');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
