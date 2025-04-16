<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function likedCourses() {
        return $this->belongsToMany(Course::class, 'likes');
    }
    public function forumRequests()
{
    return $this->hasMany(ForumUserRequest::class);
}

public function forums()
{
    return $this->belongsToMany(Forum::class, 'forum_members')->withTimestamps()->withPivot('joined_at');
}

public function forumMessages()
{
    return $this->hasMany(ForumMessage::class);
}

}
