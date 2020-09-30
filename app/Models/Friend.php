<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillble = [
        'user_id',
        'friend_id'
    ];


    public function friend() {
        return $this->hasOne('App\Models\User', 'id', 'friend_id');
    }
}
