<?php

namespace App\Http\Controllers\CMS\Category;

use Illuminate\Http\Request;
use App\Models\CMS\Category;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;

class PortfolioController extends BaseController
{
    const CATEGORY_TYPE = 2;

    public function dropdown(Request $request)
    {
        $data = Category::where("type", self::CATEGORY_TYPE)
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
        $totalRecords = Category::where("type", self::CATEGORY_TYPE)->count();
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
            "id",
            "name",
            "description",
            "created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Category::where("type", self::CATEGORY_TYPE);

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('name','LIKE','%'.$searchValue.'%')
                ->Orwhere('description','LIKE','%'.$searchValue.'%');
        }

        $dataResult  = $dataResult->orderBy(isset($cols[$columnIndex]) ? $cols[$columnIndex] : "id", isset($columnSortOrder) ? $columnSortOrder : 'DESC');

        if($count){
            return $dataResult->count();
        }else{
            return $dataResult->limit($rowperpage)->offset($row)->get();
        }

    }

    public function create(Request $request)
    {
        if(!$request->get("name")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        $checkName = Category::where("name", $request->get("name"))
            ->where("type", self::CATEGORY_TYPE)
            ->first();

        if(!is_null($checkName)){
            return response()->json([
                "status"=> false,
                "message"=> "The name has already been taken.!",
                "data"=> null
            ], 400);
        }

        $model = new Category;
        $model->slug = CommonHelper::slugify($request->get("name"));
        $model->name = $request->get("name");
        $model->description = $request->get("description");
        $model->type = self::CATEGORY_TYPE;
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been created !!",
            "data"=> $model
        ], 200);

    }

    public function update($id, Request $request)
    {
        $model = Category::where("id", $id)->where("type", self::CATEGORY_TYPE)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("name")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        $checkName = Category::where("name", $request->get("name"))
            ->where("id", "!=", $id)
            ->where("type", self::CATEGORY_TYPE)
            ->first();

        if(!is_null($checkName)){
            return response()->json([
                "status"=> false,
                "message"=> "The name has already been taken.!",
                "data"=> null
            ], 400);
        }

        $model->slug = CommonHelper::slugify($request->get("name"));
        $model->name = $request->get("name");
        $model->description = $request->get("description");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been updated !!",
            "data"=> $model
        ], 200);
    }

    public function show($id)
    {
        $model = Category::where("id", $id)->where("type", self::CATEGORY_TYPE)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $model
        ], 200);
    }

    public function destroy($id)
    {
        $model = Category::where("id", $id)->where("type", self::CATEGORY_TYPE)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Category::where("id", $id)->where("type", self::CATEGORY_TYPE)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }

}
