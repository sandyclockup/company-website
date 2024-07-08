<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = "auth_password_resets";

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];

}
