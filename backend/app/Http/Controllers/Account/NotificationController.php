<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\Notification;
use Laravel\Lumen\Routing\Controller as BaseController;

class NotificationController extends BaseController
{
    public function index()
    {
        $user = Auth::User();
        $total_unread = Notification::where("user_id", $user->id)->whereNull("readed_at")->count();
        $list = Notification::where("user_id", $user->id)->whereNull("readed_at")->limit(10)->orderBy("id", "DESC")->get();

        $respsone = [
            "total_unread"=> $total_unread,
            "list"=> $list,
        ];

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $respsone
        ], 200);
    }

    public function list(Request $request)
    {
        $user = Auth::User();
        $params = $request->all();
        $totalRecords = Notification::where("user_id", $user->id)->count();
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

        $user = Auth::User();
        $column = [
            "id",
            "created_at",
            "subject",
            "content",
            "readed_at",
            "id",
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Notification::where("user_id", $user->id);

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('subject','LIKE','%'.$searchValue.'%')
                ->Orwhere('content','LIKE','%'.$searchValue.'%');
        }

        $dataResult  = $dataResult->orderBy(isset($cols[$columnIndex]) ? $cols[$columnIndex] : "id", isset($columnSortOrder) ? $columnSortOrder : 'DESC');

        if($count){
            return $dataResult->count();
        }else{
            return $dataResult->limit($rowperpage)->offset($row)->get();
        }

    }

    public function show($id)
    {
        $user = Auth::User();
        $model = Notification::where("user_id", $user->id)->where("id", $id)->first();

        if(is_null($model)){
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(is_null($model->readed_at)){
            $model->readed_at = date("Y-m-d H:i:s");
            $model->save();
        }

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $model
        ], 200);
    }

    public function destroy($id)
    {
        $user = Auth::User();
        $model = Notification::where("user_id", $user->id)->where("id", $id)->first();

        if(is_null($model)){
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Notification::where("user_id", $user->id)->where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
