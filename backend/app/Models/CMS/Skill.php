<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = "cms_skills";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
        'description', 
        'index_ratio',
        'is_published',
        'sort'
    ];

}