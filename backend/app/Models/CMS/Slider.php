<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;

    protected $table = "cms_sliders";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'image', 
        'title', 
        'description',
        'link',
        'is_published',
        'sort'
    ];

}