<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;
// Load Models
use App\Models\CMS\Article;
use App\Models\CMS\ArticleReference;
use App\Models\CMS\Category;

class ArticleController extends BaseController
{

    public function options($type)
    {
       $data = Category::where("type", $type)
            ->select([
                "name as text",
                "id as value"
            ])
            ->orderBy("name")
            ->get();
        return response()->json($data, 200);
    }   


    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = Article::count();
        $totalDisplayRecords = $this->dataTableRender($params, true);
        $aaData = $this->dataTableRender($params, false);
        $response = array(
            "draw"=> $params["draw"],
            "iTotalRecords"=>$totalRecords,
            "iTotalDisplayRecords"=>$totalDisplayRecords,
            "aaData"=>$aaData
        );
        return response()->json($response, 200);
    }

     private function dataTableRender($request, $count = false){

        $column = [
            "cms_articles.id",
            "cms_articles.image",
            "auth_users.username",
            "cms_articles.title",
            "cms_articles.created_at",
            "cms_articles.is_published",
            "cms_articles.updated_at",
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Article::whereNotNull("cms_articles.id")
            ->select([
                "cms_articles.id",
                "cms_articles.image",
                "auth_users.username",
                "cms_articles.title",
                "cms_articles.created_at",
                "cms_articles.is_published",
                "cms_articles.updated_at",
            ])
            ->join("auth_users", "auth_users.id", "cms_articles.user_id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('cms_articles.title','LIKE','%'.$searchValue.'%')
                ->Orwhere('cms_articles.content','LIKE','%'.$searchValue.'%');
        }

        $dataResult  = $dataResult->orderBy(isset($cols[$columnIndex]) ? $cols[$columnIndex] : "cms_articles.id", isset($columnSortOrder) ? $columnSortOrder : 'DESC');

        if($count){
            return $dataResult->count();
        }else{
            return $dataResult->limit($rowperpage)->offset($row)->get();
        }

    }

    public function create(Request $request)
    {
        if(!$request->get("title")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'title' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("content")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'content' can not be empty!",
                "data"=> null
            ], 400);
        }

        $checkTitle = Article::where("title", $request->get("title"))->first();
        if(!is_null($checkTitle)){
            return response()->json([
                "status"=> false,
                "message"=> "The title has already been taken.!",
                "data"=> null
            ], 400);
        }

        $image = null;
        if($request->get("file_image")){
            $fileBin = file_get_contents($request->get("file_image"));
            $mimeType = mime_content_type($request->get("file_image"));
            $faker = Faker::create();
            $file_uuid = $faker->uuid;
            $upload = file_put_contents(storage_path('uploads/'.$file_uuid), $fileBin);
            if($upload){
                $image = $file_uuid;
            }
        }

        $user = Auth::User();

        $model = new Article;
        $model->user_id = $user->id;
        $model->image = $image;
        $model->title = $request->get("title");
        $model->slug = CommonHelper::slugify($request->get("title"));
        $model->content = $request->get("content");
        $model->is_published = $request->get("is_published");
        $model->save();

        $this->syncCategories($request, $model->id);

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been created !!",
            "data"=> $model
        ], 200);

    }

    public function update($id, Request $request)
    {
        $model = Article::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("title")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'title' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("content")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'content' can not be empty!",
                "data"=> null
            ], 400);
        }

        $checkTitle = Article::where("title", $request->get("title"))->where("id", "!=", $id)->first();
        if(!is_null($checkTitle)){
            return response()->json([
                "status"=> false,
                "message"=> "The title has already been taken.!",
                "data"=> null
            ], 400);
        }

        $image = null;
        if($request->get("file_image")){

            $file_path_current = storage_path("uploads/".$model->image);
            if(strlen($file_path_current) > 0){
                if(file_exists($file_path_current)){
                    @unlink($file_path_current);
                }
            }

            $fileBin = file_get_contents($request->get("file_image"));
            $mimeType = mime_content_type($request->get("file_image"));
            $faker = Faker::create();
            $file_uuid = $faker->uuid;
            $upload = file_put_contents(storage_path('uploads/'.$file_uuid), $fileBin);
            if($upload){
                $model->image = $file_uuid;
            }
        }

        $user = Auth::User();
        $model->user_id = $user->id;
        $model->title = $request->get("title");
        $model->slug = CommonHelper::slugify($request->get("title"));
        $model->content = $request->get("content");
        $model->is_published = $request->get("is_published");
        $model->save();

        $this->syncCategories($request, $model->id);

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been updated !!",
            "data"=> $model
        ], 200);
    }

    public function show($id)
    {
        $model = Article::where("cms_articles.id", $id)
            ->select([
                "cms_articles.*",
                "auth_users.username"
            ])
            ->join("auth_users", "auth_users.id", "cms_articles.user_id")
            ->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $category_id = ArticleReference::where("article_id", $model->id)->where("type", 1)->pluck("category_id")->toArray();
        $categories_selected = Category::whereIn("id", $category_id)->get();

        $tag_id = ArticleReference::where("article_id", $model->id)->where("type", 2)->pluck("category_id")->toArray();
        $tags_selected = Category::whereIn("id", $tag_id)->get();



        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $model,
            "categories"=> $categories_selected,
            "tags"=> $tags_selected
        ], 200);
    }

    public function destroy($id)
    {
        $model = Article::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $file_path_current = storage_path("uploads/".$model->image);
        if(strlen($file_path_current) > 0){
            if(file_exists($file_path_current)){
                @unlink($file_path_current);
            }
        }

        ArticleReference::where("article_id", $id)->delete();
        Article::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }

    private function syncCategories($request, $id)
    {

        if($request->get("categories")){
            $categories = $request->get("categories");
            ArticleReference::where("article_id", $id)->where("type", 1)->delete();
            foreach($categories as $row){
                ArticleReference::create([
                    "article_id"=> $id,
                    "category_id"=> $row,
                    "type"=> 1
                ]);
            }
        }

        if($request->get("tags")){
            $tags = $request->get("tags");
            ArticleReference::where("article_id", $id)->where("type", 2)->delete();
            foreach($tags as $row){
                ArticleReference::create([
                    "article_id"=> $id,
                    "category_id"=> $row,
                    "type"=> 2
                ]);
            }
        }

    }

}
