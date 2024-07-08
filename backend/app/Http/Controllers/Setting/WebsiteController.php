<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Models\Core\Setting;
use Laravel\Lumen\Routing\Controller as BaseController;

class WebsiteController extends BaseController
{
    public function index()
    {
        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> $this->getData()
        ], 200);
    }

    public function update(Request $request)
    {
        $data = Setting::All();
        foreach($data as $index => $row){
            if($request->get($row->key_name)){
                $key_name = $row->key_name;
                Setting::where("key_name", $key_name)->update(["key_value"=> $request->get($row->key_name)]);
            }
        }
        return response()->json([
            "status"=> true,
            "message"=> "Your setting has been updated !",
            "data"=> $this->getData()
        ], 200);
    }

    private function getData()
    {
        $response = array();
        $data = Setting::All();
        foreach($data as $index => $row){
            $response[$row->key_name] = $row->key_value;
        }
        return $response;
    }
}
