<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use SoftDeletes;

    protected $table = "cms_pricings";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
        'price', 
        'unit',
        'description',
        'link', 
        'is_recomended', 
        'is_advanced',
        'is_published',
        'sort'
    ];

}