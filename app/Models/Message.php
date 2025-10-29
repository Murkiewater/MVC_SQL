<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'message';

    protected $fillable = [
        'user_from_id',
        'user_to_id',
        'date_of_message',
        'text',
    ];

    public function from()
    {
        $this->belongsTo(Users::class, 'user_from_id');
    }

    public function to()
    {
        $this->belongsTo(Users::class, 'user_to_id');
    }
}
