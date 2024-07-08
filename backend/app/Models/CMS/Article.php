<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMS\ArticleComment;
use App\Models\CMS\ArticleCounter;
use App\Models\CMS\ArticleReference;
use App\Models\Auth\User;
use DB;

class Article extends Model
{
    use SoftDeletes;

    protected $table = "cms_articles";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'image',
        'title',
        'slug',
        'content',
        'is_published',
        'sort'
    ];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ArticleComment() {
        return $this->hasMany(ArticleComment::class);
    }

    public function ArticleCounter() {
        return $this->hasMany(ArticleCounter::class);
    }

    public function ArticleReference() {
        return $this->hasMany(ArticleReference::class);
    }

    public static function getRecent($id = null)
    {
        $newset = self::where("is_published", 1)->orderBy("id", "DESC")->first();

        return self::where("is_published", 1)
            ->where("id", "!=", $id ? $id : $newset->id)
            ->select([
                "image",
                "title",
                "slug",
                "created_at"
            ])
            ->orderBy("id", "DESC")
            ->take(5)
            ->get();
    }



    public static function getContentArticle($search = null, $category = null, $tag = null)
    {
        $model = self::where("cms_articles.is_published", 1)
            ->join("auth_users", "auth_users.id", "cms_articles.user_id")
            ->join("auth_persons", "auth_persons.user_id", "cms_articles.user_id");

        $model = $model->select([
            "cms_articles.image",
            "title",
            "slug",
            "cms_articles.created_at",
            DB::raw("SUBSTR(cms_articles.content, 1, 500) as feature_content"),
            DB::raw("
                (
                  CASE WHEN auth_persons.full_name IS NOT NULL THEN auth_persons.full_name
                  WHEN auth_persons.nick_name IS NOT NULL THEN auth_persons.nick_name
                  WHEN auth_users.username IS NOT NULL THEN auth_users.username
                  ELSE auth_users.email
                  END
                ) as author_name
            "),
            DB::raw("(
                SELECT COUNT(*) FROM cms_articles_comments
                WHERE cms_articles_comments.article_id = cms_articles.id
            ) as comment")
        ]);

        if(strlen($search) > 0)
        {
            $model = $model->where('cms_articles.title', 'like', '%' . $search . '%');
        }

        if(!is_null($category))
        {
            $category_article_id = ArticleReference::where("cms_articles_references.type", 1)
                ->where("cms_categories.slug", $category)
                ->select("article_id")
                ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
                ->groupBy("article_id")
                ->get()
                ->pluck("article_id")
                ->toArray();

            $model = $model->whereIn("cms_articles.id", $category_article_id);
        }

        if(!is_null($tag))
        {

            $tag_article_id = ArticleReference::where("cms_articles_references.type", 2)
                ->where("cms_categories.slug", $tag)
                ->select("article_id")
                ->join("cms_categories", "cms_categories.id", "cms_articles_references.category_id")
                ->groupBy("article_id")
                ->get()
                ->pluck("article_id")
                ->toArray();

            $model = $model->whereIn("cms_articles.id", $tag_article_id);
        }

        $model = $model->orderBy("cms_articles.id", "DESC");
        return $model;
    }

    public static function getArticleByTag()
    {
        return DB::select(DB::raw("
            SELECT
                cms_categories.name,
                COUNT(*) as total
            FROM cms_articles_references
            INNER JOIN cms_categories ON cms_categories.id = cms_articles_references.category_id
            INNER JOIN cms_articles ON cms_articles.id = cms_articles_references.article_id
            WHERE cms_categories.type = 3 AND cms_articles.is_published = 1
            GROUP BY cms_categories.name
        "));
    }

    public static function getArticleByCategory()
    {
        return DB::select(DB::raw("
            SELECT
                cms_categories.name,
                COUNT(*) as total
            FROM cms_articles_references
            INNER JOIN cms_categories ON cms_categories.id = cms_articles_references.category_id
            INNER JOIN cms_articles ON cms_articles.id = cms_articles_references.article_id
            WHERE cms_categories.type = 1 AND cms_articles.is_published = 1
            GROUP BY cms_categories.name
        "));
    }

}
