<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMS\ArticleReference;
use App\Models\CMS\Portfolio;

class Category extends Model
{
    use SoftDeletes;

    protected $table = "cms_categories";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'image', 
        'name', 
        'slug',
        'type',
        'description'
    ];

    public function ArticleReference() {
        return $this->hasMany(ArticleReference::class);
    }

    public function Portfolio() {
        return $this->hasMany(Portfolio::class);
    }

}