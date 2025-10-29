<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInGroups extends Model
{
    use HasFactory;

    protected $table = 'post_in_group';

    protected $fillable = [
        'user_id',
        'group_id',
        'text',
        'date_of_post',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }

    public $timestamps = false;
}
