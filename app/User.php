<?php

namespace App;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Merodiro\Friendships\Friendable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, LikerContract
{
    use Notifiable;
    use Friendable;
    use Liker;

    protected $fillable = [
        'email',
        'username',
        'firstname',
        'lastname',
        'password',
        'location',
    ];

    protected $hidden = [
        'email',
        'password',
        'created_at',
        'updated_at',
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

    public function statuses()
    {
        return $this->hasMany('App\Status');
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
