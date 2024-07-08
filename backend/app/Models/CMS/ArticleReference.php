<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Article;
use App\Models\CMS\Category;
use DB;

class ArticleReference extends Model
{
    protected $table = "cms_articles_references";

    protected $fillable = [
        'article_id', 
        'category_id', 
        'type'
    ];

    public function Article() {
        return $this->belongsTo(Article::class, 'article_id');
    }

    
    public function Category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function getByTag()
    {
        return self::where("cms_articles_references.type", 2)
            ->where("cms_articles.is_published", 1)
            ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
            ->join("cms_articles", "cms_articles.id", "cms_articles_references.article_id")
            ->orderBy("cms_categories.name")
            ->select([
                "cms_categories.name",
                "cms_categories.slug"
            ])
            ->groupBy([
                "cms_categories.name",
                "cms_categories.slug"
            ])
            ->get();
    }

    public static function getByCategory()
    {
        return self::where("cms_articles_references.type", 1)
            ->where("cms_articles.is_published", 1)
            ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
            ->join("cms_articles", "cms_articles.id", "cms_articles_references.article_id")
            ->orderBy("cms_categories.name")
            ->select([
                "cms_categories.name",
                "cms_categories.slug",
                DB::raw("COUNT(*) as total")
            ])
            ->groupBy([
                "cms_categories.name",
                "cms_categories.slug"
            ])
            ->get();
    }

}