<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
// Load Models
use App\Models\CMS\Skill;

class SkillController extends BaseController
{
    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = Skill::count();
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
            "index_ratio",
            "sort",
            "is_published",
            "created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Skill::whereNotNull("id");

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

        $model = new Skill;
        $model->name = $request->get("name");
        $model->description = $request->get("description");
        $model->index_ratio = $request->get("index_ratio");
        $model->is_published = $request->get("is_published");
        $model->sort = $request->get("sort");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been created !!",
            "data"=> $model
        ], 200);

    }

    public function update($id, Request $request)
    {
        $model = Skill::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $model->name = $request->get("name");
        $model->description = $request->get("description");
        $model->index_ratio = $request->get("index_ratio");
        $model->is_published = $request->get("is_published");
        $model->sort = $request->get("sort");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been updated !!",
            "data"=> $model
        ], 200);
    }

    public function show($id)
    {
        $model = Skill::where("id", $id)->first();

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
        $model = Skill::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Skill::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
