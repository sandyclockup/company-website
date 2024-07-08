<?php

namespace App\Http\Controllers\CMS\Reference;

use Illuminate\Http\Request;
use App\Models\CMS\Contact;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;

class ContactController extends BaseController
{

    public function getTotal(Request $request)
    {
        $totalRecords = Contact::count();
        return response()->json(["total"=> $totalRecords], 200);
    }

    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = Contact::count();
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
            "cms_contacts.id",
            "cms_contacts.created_at",
            "cms_contacts.name",
            "cms_contacts.email",
            "cms_contacts.subject",
            "cms_contacts.id",
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Contact::whereNotNull("cms_contacts.id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('name','LIKE','%'.$searchValue.'%')
                ->Orwhere('email','LIKE','%'.$searchValue.'%')
                ->Orwhere('subject','LIKE','%'.$searchValue.'%');
        }

        $dataResult  = $dataResult->orderBy(isset($cols[$columnIndex]) ? $cols[$columnIndex] : "cms_contacts.id", isset($columnSortOrder) ? $columnSortOrder : 'DESC');

        if($count){
            return $dataResult->count();
        }else{
            return $dataResult->limit($rowperpage)->offset($row)->get();
        }

    }

    public function show($id)
    {
        $model = Contact::where("id", $id)->first();

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
        $model = Contact::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Contact::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
