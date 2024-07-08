<?php

namespace App\Http\Controllers\CMS\Content;

use Illuminate\Http\Request;
use App\Helpers\CommonHelper;
use Laravel\Lumen\Routing\Controller as BaseController;
use Faker\Factory as Faker;
// Load Models
use App\Models\CMS\Portfolio;
use App\Models\CMS\PortfolioImage;

class PortfolioImageController extends BaseController
{
    public function list($id)
    {

        $model = Portfolio::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The portfolio with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $data = PortfolioImage::where("portfolio_id", $id)->orderBy("id", "DESC")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }

    public function create($id, Request $request)
    {
        $model = Portfolio::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The portfolio with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        if(!$request->file('files')){
            return response()->json([
                "status"=> false,
                "message"=> "The field input 'files' can not be empty!",
                "data"=> null
            ], 400);
        }


        $files = $request->file('files');
        foreach($files as $file)
        {
            $faker = Faker::create();
            $file_uuid = $faker->uuid;
            $fileName = $file_uuid;
            $upload = $file->move(storage_path('uploads'), $fileName);
            PortfolioImage::create([
                "portfolio_id"=> $id,
                "image"=> "uploads/".$fileName,
                "is_primary"=> 0
            ]);
        }

        $data = PortfolioImage::where("portfolio_id", $id)->orderBy("id", "DESC")->get();

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $data
        ], 200);
    }


    public function primary($id)
    {
        $model = PortfolioImage::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        PortfolioImage::where("id", "!=", $id)->where("portfolio_id", $model->portfolio_id)->update(["is_primary"=> 0]);
        PortfolioImage::where("id",  $id)->where("portfolio_id", $model->portfolio_id)->update(["is_primary"=> 1]);
        $images = PortfolioImage::where("portfolio_id", $model->portfolio_id)->orderBy("id", "DESC")->get();
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $images
        ], 200);
    }

    public function destroy($id)
    {
        $model = PortfolioImage::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        PortfolioImage::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);
    }
}
