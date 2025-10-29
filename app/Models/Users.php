<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    public function postsInGroups()
    {
        return $this->hasMany(PostInGroups::class, 'user_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'users_groups', 'user_id', 'group_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Messages::class, 'user_from_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Messages::class, 'user_to_id');
    }

    public function friends()
    {
        $friends1 = Friends::where('user1_id', $this->id)->pluck('user2_id');
        $friends2 = Friends::where('user2_id', $this->id)->pluck('user1_id');
        $friendIds = $friends1->merge($friends2);
        return Users::whereIn('id', $friendIds)->get();
    }
}