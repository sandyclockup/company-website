<?php

namespace App\Http\Controllers\Page;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CMS\Article;
use App\Models\CMS\ArticleComment;
use App\Models\CMS\ArticleReference;
use App\Models\CMS\ArticleCounter;
use App\Models\CMS\Category;
use App\Models\Auth\User;

class BlogController extends BaseController
{
    public function GetPostArticle(Request $request)
    {
        $limit = $request->get("limit") ? $request->get("limit") : 10;
        $page = $request->get("page") ? $request->get("page") : 1;
        $offset = $page <= 1 ? 0 : ($page-1) * $limit;
        $search = $request->get("search") ? $request->get("search") : "";
        $order_by = $request->get("order_by") ? $request->get("order_by") : "id";
        $order_type = $request->get("order_type") ? $request->get("order_type") : "desc";

        $total = Article::where("cms_articles.is_published", 1)->count();
        $data = Article::selectRaw("
            cms_articles.*,
            auth_users.username,
            auth_users.email,
            auth_persons.full_name,
            auth_persons.nick_name,
            (
              SELECT COUNT(*) FROM cms_articles_comments WHERE cms_articles_comments.article_id = cms_articles.id
            ) as total_comments
        ")
        ->where("is_published", 1)
        ->join("auth_users", "auth_users.id", "cms_articles.user_id")
        ->join("auth_persons", "auth_persons.user_id", "auth_users.id");

        if(strlen($search) > 0){
            $data = $data->where(function($q) use ($search) {
                $q->Where("cms_articles.title", 'LIKE', '%' . $search . '%');
                $q->orWhere("cms_articles.slug", 'LIKE', '%' . $search . '%');
                $q->orWhere("cms_articles.content", 'LIKE', '%' . $search . '%');
            });
            $total = $data->count();
        }

        if($request->get("category")){
            $category_id = $request->get("category");
            $articles_categories = ArticleReference::where("category_id", $category_id)->pluck("article_id")->toArray();
            $data = $data->whereIn("cms_articles.id", $articles_categories);
        }

         if($request->get("tag")){
            $tag_id = $request->get("tag");
            $articles_tags = ArticleReference::where("category_id", $tag_id)->pluck("article_id")->toArray();
            $data = $data->whereIn("cms_articles.id", $articles_tags);
        }


        $data = $data->take($limit)->offset($offset)->orderBy($order_by, $order_type);

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data->get(),
            "total_data"=> ceil($total/$limit),
            "limit"=> $limit,
            "page"=> $page
        ], 200);
    }

    public function GetArticleCategory()
    {
        $category_id = ArticleReference::where("type", 1)->pluck("category_id")->toArray();
        $data = Category::whereIn("id", $category_id)->get();
        $result = array();

        foreach($data as $row){
            $result[] = array(
                "id"=> $row->id,
                "name"=>$row->name,
                "total"=> ArticleReference::where("category_id", $row->id)->count()
            );
        }

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }

    public function GetArticleTag()
    {
        $category_id = ArticleReference::where("type", 2)->pluck("category_id")->toArray();
        $data = Category::whereIn("id", $category_id)->get();
        $result = array();

        foreach($data as $row){
            $result[] = array(
                "id"=> $row->id,
                "name"=>$row->name,
                "total"=> ArticleReference::where("category_id", $row->id)->count()
            );
        }

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $result
        ], 200);
    }

    public function GetReadArticle($slug)
    {
        $model = Article::where("slug", $slug)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The article with slug ".$slug." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $article = $model;


        $category_id = ArticleReference::where("article_id", $article->id)->where("type", 1)->pluck("category_id")->toArray();
        $categories_selected = Category::whereIn("id", $category_id)->get();

        $tag_id = ArticleReference::where("article_id", $article->id)->where("type", 2)->pluck("category_id")->toArray();
        $tags_selected = Category::whereIn("id", $tag_id)->get();

        if(Auth::check()){

            $auth_user = Auth::User();
            $ip_address = request()->ip();

            $check = ArticleCounter::where("article_id", $article->id)
                ->where("user_id", $auth_user->id)
                ->where("ip_address", $ip_address)
                ->whereRaw('Date(created_at) = CURDATE()')
                ->first();

            if(is_null($check))
            {
                ArticleCounter::create([
                    "article_id"=> $article->id,
                    "user_id"=> $auth_user->id,
                    "ip_address"=> $ip_address
                ]);
            }
        }

            $author = User::select([
                "auth_users.*", 
                "auth_persons.full_name", 
                "auth_persons.nick_name",
                "auth_persons.image",
                "auth_persons.twitter",
                "auth_persons.facebook",
                "auth_persons.instagram",
                "auth_persons.about_me"
            ])
            ->join("auth_persons", "auth_persons.user_id", "auth_users.id")
            ->where("auth_users.id", $article->user_id)
            ->first();

        $response = [
            "article"=> $article,
            "author"=> $author,
            "categories"=> $categories_selected,
            "tags"=> $tags_selected,
            "comments"=> ArticleComment::getComment($article->id),
            "total_comment"=> ArticleComment::where("article_id", $article->id)->count()
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $response
        ], 200);

    }

    public function GetArticleComment($id)
    {
        $model = Article::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The article with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $data = [
            "comments"=> ArticleComment::getComment($id),
            "total_comment"=> ArticleComment::where("article_id", $id)->count()
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);

    }

    public function CreateArticleComment($id, Request $request)
    {

        if (!Auth::check()) {
            return response()->json([
                "status"=> false,
                "message"=> "Please login to continue !!",
                "data"=> null
            ], 401);
        }


        $user = Auth::User();
        $model = Article::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The article with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("comment")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'comment' can not be empty!",
                "data"=> null
            ], 400);
        }

        $model = new ArticleComment;
        $model->parent_id = $request->get("parent_id");
        $model->article_id = $id;
        $model->user_id = $user->id;
        $model->comment = $request->get("comment");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been created !",
            "data"=> $model
        ], 200);

    }

    public function DeleteArticleComment($id)
    {

        if (!Auth::check()) {
            return response()->json([
                "status"=> false,
                "message"=> "Please login to continue !!",
                "data"=> null
            ], 401);
        }

        $user = Auth::User();
        $model = ArticleComment::where("id", $id)->where("user_id", $user->id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The comment with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        ArticleComment::where("id", $id)->where("user_id", $user->id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }

}
