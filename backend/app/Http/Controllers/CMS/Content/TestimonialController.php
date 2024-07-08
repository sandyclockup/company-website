<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;
// Load Models
use App\Models\CMS\Testimonial;
use App\Models\CMS\Customer;

class TestimonialController extends BaseController
{
    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = Testimonial::count();
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
            "cms_testimonials.id",
            "cms_testimonials.image",
            "cms_customers.name",
            "cms_testimonials.name",
            "cms_testimonials.position",
            "cms_testimonials.sort",
            "cms_testimonials.is_published",
            "cms_testimonials.created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Testimonial::select([
            "cms_testimonials.id",
            "cms_testimonials.image",
            "cms_customers.name as customer_name",
            "cms_testimonials.name",
            "cms_testimonials.position",
            "cms_testimonials.sort",
            "cms_testimonials.is_published",
            "cms_testimonials.created_at"
        ])->join("cms_customers", "cms_customers.id", "cms_testimonials.customer_id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('cms_customers.name','LIKE','%'.$searchValue.'%')
                ->where('cms_testimonials.name','LIKE','%'.$searchValue.'%')
                ->Orwhere('cms_testimonials.position','LIKE','%'.$searchValue.'%');
        }

        $dataResult  = $dataResult->orderBy(isset($cols[$columnIndex]) ? $cols[$columnIndex] : "cms_testimonials.id", isset($columnSortOrder) ? $columnSortOrder : 'DESC');

        if($count){
            return $dataResult->count();
        }else{
            return $dataResult->limit($rowperpage)->offset($row)->get();
        }

    }

    public function create(Request $request)
    {
        if(!$request->get("customer_id")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'customer_id' can not be empty!",
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

        if(!$request->get("position")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'position' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("quote")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'quote' can not be empty!",
                "data"=> null
            ], 400);
        }

        $customer = Customer::where("id", $request->get("customer_id"))->first();
        if(is_null($customer))
        {
            return response()->json([
                "status"=> false,
                "message"=> "These customer with id ".$request->get("customer_id")." do not match our records.",
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

        $model = new Testimonial;
        $model->customer_id = $request->get("customer_id");
        $model->image = $image;
        $model->name = $request->get("name");
        $model->position = $request->get("position");
        $model->quote = $request->get("quote");
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
        $model = Testimonial::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("customer_id")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'customer_id' can not be empty!",
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

        if(!$request->get("position")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'position' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("quote")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'quote' can not be empty!",
                "data"=> null
            ], 400);
        }

        $customer = Customer::where("id", $request->get("customer_id"))->first();
        if(is_null($customer))
        {
            return response()->json([
                "status"=> false,
                "message"=> "These customer with id ".$request->get("customer_id")." do not match our records.",
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


        $model->customer_id = $request->get("customer_id");
        $model->name = $request->get("name");
        $model->position = $request->get("position");
        $model->quote = $request->get("quote");
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
        $model = Testimonial::where("cms_testimonials.id", $id)
            ->select([
                "cms_testimonials.*",
                "cms_customers.name as customer_name"
            ])
            ->join("cms_customers", "cms_customers.id", "cms_testimonials.customer_id")
            ->first();

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
        $model = Testimonial::where("id", $id)->first();

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

        Testimonial::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
