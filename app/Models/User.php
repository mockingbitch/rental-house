<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'description',
        'avatar',
        'ward_id',
        'status',
        'country_id',
        'city_id',
        'vendor',
        'region',
        'remember_token',
        'email_verified_at',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        // 'country',
        // 'city',
        // 'kids',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function country()
    // {
    //     return $this->belongsTo(Country::class, 'country_id',  'id');
    // }

    // public function city()
    // {
    //     return $this->belongsTo(City::class, 'city_id', 'id');
    // }

    // public function kids()
    // {
    //     return $this->hasMany(Kid::class, 'parent_id', 'id');
    // }

    // public function user_schedules()
    // {
    //     return $this->hasMany(UserSchedule::class, 'user_id', 'id');
    // }

    // /**
    //  * The channels the user receives notification broadcasts on.
    //  */
    // public function receivesBroadcastNotificationsOn(): string
    // {
    //     if ($this->role == 2) :
    //         return 'Teacher.'.$this->id;
    //     endif;

    //     return 'User.'.$this->id;
    // }
}
