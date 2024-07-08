<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = "cms_visitors";

    protected $fillable = [
        'ip_address', 
        'url'
    ];

}