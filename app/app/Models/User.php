<?php

namespace App\Models;

use App\Models\Address\Ward;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes;

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
        'province_code',
        'district_code',
        'ward_code',
        'status',
        'vendor',
        'region',
        'remember_token',
        'email_verified_at',
        'birthday',
        'verify_lessor',
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

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }
}
