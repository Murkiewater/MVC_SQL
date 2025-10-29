<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'groups';

    public function posts()
    {
        return $this->hasMany(PostInGroups::class, 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany(Users::class, 'users_groups', 'group_id', 'user_id');
    }
}