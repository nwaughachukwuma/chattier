<?php

namespace App;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Merodiro\Friendships\Friendable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Friendable;

    protected $fillable = [
        'email',
        'username',
        'firstname',
        'lastname',
        'password',
        'location',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'avatar',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarAttribute()
    {
        $hash = md5($this->email);
        return "https://www.gravatar.com/avatar/{$hash}?d=mm&s=64";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
