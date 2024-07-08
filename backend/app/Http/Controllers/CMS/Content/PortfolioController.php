<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
// Load Models
use App\Models\CMS\Portfolio;
use App\Models\CMS\Customer;
use App\Models\CMS\Category;

class PortfolioController extends BaseController
{
    public function list(Request $request)
    {
       $params = $request->all();
        $totalRecords = Portfolio::count();
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
            "cms_portfolios.id",
            "cms_customers.name",
            "cms_categories.name",
            "cms_portfolios.title",
            "cms_portfolios.sort",
            "cms_portfolios.is_published",
            "cms_portfolios.created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $dataResult = Portfolio::whereNotNull("cms_portfolios.id")
            ->select([
                "cms_portfolios.id",
                "cms_customers.name as customer_name",
                "cms_categories.name as category_name",
                "cms_portfolios.title",
                "cms_portfolios.sort",
                "cms_portfolios.is_published",
                "cms_portfolios.created_at"
            ])
            ->join("cms_categories", "cms_categories.id", "cms_portfolios.category_id")
            ->join("cms_customers", "cms_customers.id", "cms_portfolios.customer_id");

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('cms_customers.name','LIKE','%'.$searchValue.'%')
                ->Orwhere('"cms_categories.name','LIKE','%'.$searchValue.'%')
                ->Orwhere('"cms_portfolios.title','LIKE','%'.$searchValue.'%');
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
        if(!$request->get("customer_id")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'customer_id' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("category_id")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'customer_id' can not be empty!",
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

        if(!$request->get("description")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'description' can not be empty!",
                "data"=> null
            ], 400);
        }

        $customer = Customer::where("id", $request->get("customer_id"))->first();
        $category = Category::where("id", $request->get("category_id"))->where("type", 2)->first();

        if(is_null($customer)){
            return response()->json([
                "status"=> false,
                "message"=> "The customer with id ".$request->get("customer_id")." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(is_null($category)){
            return response()->json([
                "status"=> false,
                "message"=> "The category with id ".$request->get("category_id")." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $model = new Portfolio;
        $model->customer_id = $request->get("customer_id");
        $model->category_id = $request->get("category_id");
        $model->title = $request->get("title");
        $model->description = $request->get("description");
        $model->project_date = $request->get("project_date");
        $model->project_url = $request->get("project_url");
        $model->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
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
        $model = Portfolio::where("id", $id)->first();

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

        if(!$request->get("category_id")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'customer_id' can not be empty!",
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

        if(!$request->get("description")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'description' can not be empty!",
                "data"=> null
            ], 400);
        }

        $customer = Customer::where("id", $request->get("customer_id"))->first();
        $category = Category::where("id", $request->get("category_id"))->where("type", 2)->first();

        if(is_null($customer)){
            return response()->json([
                "status"=> false,
                "message"=> "The customer with id ".$request->get("customer_id")." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(is_null($category)){
            return response()->json([
                "status"=> false,
                "message"=> "The category with id ".$request->get("category_id")." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $model->customer_id = $request->get("customer_id");
        $model->category_id = $request->get("category_id");
        $model->title = $request->get("title");
        $model->description = $request->get("description");
        $model->project_date = $request->get("project_date");
        $model->project_url = $request->get("project_url");
        $model->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
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
        $select = [
            "cms_portfolios.*",
            "cms_customers.name as customer_name",
            "cms_categories.name as category_name",
        ];
        $model = Portfolio::select($select)
            ->where("cms_portfolios.id", $id)
            ->join("cms_categories", "cms_categories.id", "cms_portfolios.category_id")
            ->join("cms_customers", "cms_customers.id", "cms_portfolios.customer_id")
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
        $model = Portfolio::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Portfolio::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
