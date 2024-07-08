<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Auth\User;
use App\Models\Auth\Person;
use App\Models\Auth\Notification;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function list(Request $request)
    {
        $params = $request->all();
        $totalRecords = User::count();
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
            "username",
            "email",
            "phone",
            "is_admin",
            "is_banned",
            "verified",
            "created_at"
        ];

        $cols = $column;
        $row = $request["start"];
        $rowperpage = $request["length"];
        $columnIndex = $request["order"][0]["column"];
        $columnSortOrder = $request["order"][0]["dir"];
        $searchValue = $request["search"]["value"];

        $user = Auth::User();
        $dataResult = User::where("id", "!=", $user->id);

        if(strlen($searchValue) > 0){
            $dataResult = $dataResult
                ->where('username','LIKE','%'.$searchValue.'%')
                ->Orwhere('email','LIKE','%'.$searchValue.'%')
                ->Orwhere('phone','LIKE','%'.$searchValue.'%');
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
        if(!$request->get("username")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'username' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'email' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("password")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'password' can not be empty!",
                "data"=> null
            ], 400);
        }

        $username =  $request->get("username");
        $email =  $request->get("email");
        $phone = $request->get("phone");
        $password =  $request->get("password");

        if(strlen($password) < 8){
            return response()->json([
                "status"=> false,
                "message"=> "The password must be at least 8 characters.!",
                "data"=> null
            ], 400);
        }

        $checkUserName = User::where("username", $username)->first();
        $checkUserEmail = User::where("email", $email)->first();
        $checkUserPhone = User::where("phone", $phone)->first();

        if(!is_null($checkUserName)){
            return response()->json([
                "status"=> false,
                "message"=> "The username has already been taken.!",
                "data"=> null
            ], 400);
        }

        if(!is_null($checkUserEmail)){
            return response()->json([
                "status"=> false,
                "message"=> "The email address has already been taken.!",
                "data"=> null
            ], 400);
        }

        if($request->get("phone") && !is_null($checkUserPhone)){
            return response()->json([
                "status"=> false,
                "message"=> "The phone number has already been taken.!",
                "data"=> null
            ], 400);
        }

        $user = new User;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->email = $email;
        $user->is_admin = $request->get("is_admin") ? $request->get("is_admin") : 0;
        $user->is_banned = $request->get("is_banned") ? $request->get("is_banned") : 0;
        $user->verified = 1;
        if($request->get("phone")){
            $user->phone = $phone;
        }
        $user->save();

        $person = new Person;
        $person->user_id = $user->id;
        $person->nick_name = $request->get("nick_name");
        $person->full_name = $request->get("full_name");
        $person->gender = $request->get("gender") ? $request->get("gender") : 0;
        $person->birth_date = $request->get("birth_date");
        $person->address = $request->get("address");
        $person->about_me = $request->get("about_me");
        $person->twitter = $request->get("twitter");
        $person->facebook = $request->get("facebook");
        $person->instagram = $request->get("instagram");
        $person->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been created !!",
            "data"=> [
                "user"=> $user,
                "person"=> $person
            ]
        ], 200);

    }

    public function update($id, Request $request)
    {
        $model = User::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $user = $model;
        $person = Person::where("user_id", $id)->first();

        if(!$request->get("username")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'username' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'email' can not be empty!",
                "data"=> null
            ], 400);
        }

        

        $username =  $request->get("username");
        $email =  $request->get("email");
        $phone = $request->get("phone");
        $password =  $request->get("password");

        if($request->get("password")){
            if(strlen($password) < 8){
                return response()->json([
                    "status"=> false,
                    "message"=> "The password must be at least 8 characters.!",
                    "data"=> null
                ], 400);
            }
        }

        
        $checkUserName = User::where("username", $username)->where("id", "!=", $id)->first();
        $checkUserEmail = User::where("email", $email)->where("id", "!=", $id)->first();
        $checkUserPhone = User::where("phone", $phone)->where("id", "!=", $id)->first();

        if(!is_null($checkUserName)){
            return response()->json([
                "status"=> false,
                "message"=> "The username has already been taken.!",
                "data"=> null
            ], 400);
        }

        if(!is_null($checkUserEmail)){
            return response()->json([
                "status"=> false,
                "message"=> "The email address has already been taken.!",
                "data"=> null
            ], 400);
        }

        if($request->get("phone") && !is_null($checkUserPhone)){
            return response()->json([
                "status"=> false,
                "message"=> "The phone number has already been taken.!",
                "data"=> null
            ], 400);
        }

        if($request->get("password")){
            if(strlen($password) < 8){
                return response()->json([
                    "status"=> false,
                    "message"=> "The password must be at least 8 characters.!",
                    "data"=> null
                ], 400);
            }
        }

        $user->username = $username;
        $user->email = $email;
        $user->is_admin = $request->get("is_admin") ? $request->get("is_admin") : 0;
        $user->is_banned = $request->get("is_banned") ? $request->get("is_banned") : 0;


        if($request->get("phone")){
            $user->phone = $phone;
        }

        if($request->get("password")){
            $user->password = Hash::make($password);
        }

        $user->save();

        $person->nick_name = $request->get("nick_name");
        $person->full_name = $request->get("full_name");
        $person->gender = $request->get("gender") ? $request->get("gender") : 0;
        $person->birth_date = $request->get("birth_date");
        $person->address = $request->get("address");
        $person->about_me = $request->get("about_me");
        $person->twitter = $request->get("twitter");
        $person->facebook = $request->get("facebook");
        $person->instagram = $request->get("instagram");
        $person->save();

        return response()->json([
            "status"=> true,
            "message"=> "Yor record has been updated !!",
            "data"=> [
                "user"=> $user,
                "person"=> $person
            ]
        ], 200);

    }

    public function show($id)
    {
        $model = User::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        $person = Person::where("user_id", $id)->first();

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> [
                "user"=> $model,
                "person"=> $person
            ]
        ], 200);

    }

    public function destroy($id)
    {
        $model = User::where("id", $id)->first();

        if(is_null($model))
        {
            return response()->json([
                "status"=> false,
                "message"=> "The record with id ".$id." was not found in our record !!",
                "data"=> null
            ], 400);
        }

        Notification::where("user_id", $id)->delete();
        Person::where("user_id", $id)->delete();
        User::where("id", $id)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your record has been deleted !",
            "data"=> null
        ], 200);

    }

}
