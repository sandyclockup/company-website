<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;

    protected $table = "cms_features";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'icon', 
        'title', 
        'description',
        'is_published',
        'sort'
    ];

}