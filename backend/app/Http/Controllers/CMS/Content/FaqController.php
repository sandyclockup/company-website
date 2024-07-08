<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
// Load Models
use App\Models\CMS\Faq;

class FaqController extends BaseController
{
    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = Faq::count();
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
            "question",
            "answer",
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

        $dataResult = Faq::whereNotNull("id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('question','LIKE','%'.$searchValue.'%')
                ->Orwhere('answer','LIKE','%'.$searchValue.'%');
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
        if(!$request->get("question")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'question' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("answer")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'answer' can not be empty!",
                "data"=> null
            ], 400);
        }

        $model = new Faq;
        $model->question = $request->get("question");
        $model->answer = $request->get("answer");
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
        $model = Faq::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("question")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'question' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("answer")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'answer' can not be empty!",
                "data"=> null
            ], 400);
        }

        $model->question = $request->get("question");
        $model->answer = $request->get("answer");
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
        $model = Faq::where("id", $id)->first();

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
        $model = Faq::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Faq::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
