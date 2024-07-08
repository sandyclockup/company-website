<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table = "cms_services";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'icon', 
        'title', 
        'description',
        'is_published',
        'sort'
    ];

}