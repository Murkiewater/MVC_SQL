<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $fillable = [
        'user1_id',
        'user2_id',
        'date_of_friendship',
    ];

    public $timestamps = false;
}
