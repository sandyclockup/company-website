<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $table = "cms_faqs";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'question', 
        'answer', 
        'is_published',
        'sort'
    ];

}