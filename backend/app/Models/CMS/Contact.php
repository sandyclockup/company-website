<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = "cms_contacts";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
        'email', 
        'subject',
        'message'
    ];

}