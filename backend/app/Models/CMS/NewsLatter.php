<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class NewsLatter extends Model
{

    protected $table = "cms_newsletter";

    protected $fillable = [
        'ip_address', 
        'email'
    ];

}