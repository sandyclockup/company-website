<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;
use App\Models\CMS\Article;
use App\Models\Auth\User;
use DB;

class ArticleComment extends Model
{
    protected $table = "cms_articles_comments";

    protected $fillable = [
        'parent_id',
        'article_id',
        'user_id',
        'comment'
    ];


    public function Article() {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getComment($article_id)
    {
        $data = self::where("cms_articles_comments.article_id", $article_id)
            ->select([
                "cms_articles_comments.*",
                "auth_persons.image",
                DB::raw("
                    (
                    CASE WHEN auth_persons.full_name IS NOT NULL THEN auth_persons.full_name
                    WHEN auth_persons.nick_name IS NOT NULL THEN auth_persons.nick_name
                    WHEN auth_users.username IS NOT NULL THEN auth_users.username
                    ELSE auth_users.email
                    END
                    ) as author_name
                "),
            ])
            ->join("auth_users", "auth_users.id", "cms_articles_comments.user_id")
            ->join("auth_persons", "auth_persons.user_id", "cms_articles_comments.user_id")
            ->orderBy("cms_articles_comments.id", "DESC")
            ->orderBy("cms_articles_comments.parent_id", "ASC")
            ->get();

        return $data;
    }

}
