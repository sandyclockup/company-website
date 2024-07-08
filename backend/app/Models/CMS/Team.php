<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $table = "cms_teams";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'image', 
        'name', 
        'email',
        'phone',
        'position_name', 
        'twitter', 
        'facebook',
        'instagram',
        'linked_in', 
        'address',
        'sort',
        'is_published'
    ];

   

}