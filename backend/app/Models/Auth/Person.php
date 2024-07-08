<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;

class Person extends Model
{
    protected $table = "auth_persons";

    protected $fillable = [
        'user_id', 
        'image', 
        'nick_name',
        'full_name',
        'gender',
        'birth_date',
        'address',
        'about_me',
        'twitter',
        'facebook',
        'instagram'
    ];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}