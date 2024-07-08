<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Faker\Factory as Faker;


class UploadController extends BaseController
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except'=> 'download']);
    }

    public function single(Request $request)
    {

        if(!$request->file('file')){
            return response()->json([
                "status"=> false,
                "message"=> "The field input 'file' can not be empty!",
                "data"=> null
            ], 400);
        }

        $faker = Faker::create();
        $file_uuid = $faker->uuid;
        $file = $request->file('file');
        $fileName = $file_uuid;
        $upload = $request->file('file')->move(storage_path('uploads'), $fileName);
        return response()->json([
            "status"=> true,
            "message"=> "Your file has been uploaded",
            "data"=> "uploads/".$fileName
        ], 200);

    }

    public function multiple(Request $request)
    {
        if(!$request->file('files')){
            return response()->json([
                "status"=> false,
                "message"=> "The field input 'files' can not be empty!",
                "data"=> null
            ], 400);
        }

        $response = [];
        $files = $request->file('files');
        foreach($files as $file)
        {
            $faker = Faker::create();
            $file_uuid = $faker->uuid;
            $fileName = $file_uuid;
            $upload = $file->move(storage_path('uploads'), $fileName);
            $response[] = "uploads/".$fileName;
        }

        return response()->json([
            "status"=> true,
            "message"=> "Your files has been uploaded",
            "data"=> $response
        ], 200);

    }

    public function download($path)
    {

        $file_path = storage_path("uploads/".$path);
        if (file_exists($file_path)) {
            $file = file_get_contents($file_path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }

        return response()->json([
            "status"=> false,
            "message"=> "File not found",
            "data"=> null
        ], 400);

    }

}
