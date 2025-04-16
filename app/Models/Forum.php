<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'forum_members')->withTimestamps()->withPivot('joined_at');
    }

    public function requests()
    {
        return $this->hasMany(ForumUserRequest::class);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\ForumMessage::class);
    }
    
    public function approvedUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'forum_user_requests')
                    ->wherePivot('status', 'accepted');
    }
    
}
