<?php

namespace App\Http\Controllers\CMS\Reference;

use Illuminate\Http\Request;
use App\Models\CMS\Customer;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;

class CustomerController extends BaseController
{
     public function dropdown(Request $request)
    {
        $data = Customer::whereNotNull("id")
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
        $totalRecords = Customer::count();
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
            "email",
            "phone",
            "address",
            "is_published",
            "created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Customer::whereNotNull("id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('name','LIKE','%'.$searchValue.'%')
                ->Orwhere('email','LIKE','%'.$searchValue.'%')
                ->Orwhere('phone','LIKE','%'.$searchValue.'%')
                ->Orwhere('address','LIKE','%'.$searchValue.'%');
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

        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("phone")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("address")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'address' can not be empty!",
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

        $model = new Customer;
        $model->image = $image;
        $model->name = $request->get("name");
        $model->email = $request->get("email");
        $model->phone = $request->get("phone");
        $model->address = $request->get("address");
        $model->is_published = $request->get("is_published");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been created !!",
            "data"=> $model
        ], 200);

    }

    public function update($id, Request $request)
    {
        $model = Customer::where("id", $id)->first();

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

        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("phone")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'name' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("address")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'address' can not be empty!",
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

        $model->name = $request->get("name");
        $model->email = $request->get("email");
        $model->phone = $request->get("phone");
        $model->address = $request->get("address");
        $model->is_published = $request->get("is_published");
        $model->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been updated !!",
            "data"=> $model
        ], 200);

    }

    public function show($id)
    {
        $model = Customer::where("id", $id)->first();

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
        $model = Customer::where("id", $id)->first();

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

        Customer::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }

}
