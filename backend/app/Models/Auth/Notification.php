<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;

class Notification extends Model
{
    protected $table = "auth_notifications";

    protected $fillable = [
        'user_id', 
        'subject', 
        'content',
        'readed_at'
    ];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}