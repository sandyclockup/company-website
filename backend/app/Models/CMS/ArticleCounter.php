<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Article;
use App\Models\Auth\User;

class ArticleCounter extends Model
{
    protected $table = "cms_articles_counters";

    protected $fillable = [
        'article_id', 
        'user_id', 
        'ip_address'
    ];

    public function Article() {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}