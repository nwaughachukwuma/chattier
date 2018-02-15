<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'body',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
        'updated_at',
    ];

    protected $appends = [
        'of_friend',
        'reply_count',
    ];

    protected $with = [
        'user',
    ];

    public function getOfFriendAttribute()
    {
        return auth()->check()
            ? auth()->user()->isFriendsWith($this->user)
            : false;
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Status', 'parent_id');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
