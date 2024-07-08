<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Auth\Person;
use App\Models\Auth\User;
use Faker\Factory as Faker;

class ProfileController extends BaseController
{

    public function checkToken(){
        return response()->json(["status"=> true]);
    }

    public function uploadImage(Request $request)
    {

        $user = Auth::User();
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

        $person = Person::where("user_id", $user->id)->first();
        $file_path_current = storage_path("uploads/".$person->image);
        if(strlen($file_path_current) > 0){
            if(file_exists($file_path_current)){
                @unlink($file_path_current);
            }
        }

        $person->image = $file_uuid;
        $person->save();

        return response()->json(["file_uuid"=> $file_uuid]);
    }

    public function profileView()
    {
        $user = Auth::User();
        $person = Person::where("user_id", $user->id)->first();

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> [
                "user"=> $user,
                "person"=> $person
            ]
        ], 200);
    }


    public function passwordUpdate(Request $request)
    {
        $user = Auth::User();

        if(!$request->get("old_password")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'old_password' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("new_password")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'new_password' can not be empty!",
                "data"=> null
            ], 400);
        }

        if(!$request->get("new_password_confirm")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'new_password_confirm' can not be empty!",
                "data"=> null
            ], 400);
        }

        $old_password = $request->get("old_password");
        $new_password = $request->get("new_password");
        $new_password_confirm = $request->get("new_password_confirm");

        if(strlen($new_password) < 8){
            return response()->json([
                "status"=> false,
                "message"=> "The password must be at least 8 characters.!",
                "data"=> null
            ], 400);
        }

        if($new_password != $new_password_confirm){
            return response()->json([
                "status"=> false,
                "message"=> "The password confirmation does not match.!",
                "data"=> null
            ], 400);
        }

        $hashedPassword = $user->password;
        if (!Hash::check($old_password, $hashedPassword)) {
            return response()->json([
                "status"=> false,
                "message"=> "Incorrect current password please try again !!",
                "data"=> null
            ], 400);
        }

        $user->password = Hash::make($new_password);
        $user->verified = 1;
        $user->verification_token = null;
        $user->save();

        return response()->json([
            "status"=> true,
            "message"=> "Your password has been reset!",
            "data"=> null
        ], 200);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::User();

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

        $username = $request->get("username");
        $email = $request->get("email");
        $phone = $request->get("phone");

        $checkUserName  = User::where("username", $username)->where("id", "!=", $user->id)->first();
        $checkUserEmail = User::where("email", $email)->where("id", "!=", $user->id)->first();
        $checkUserPhone = User::where("phone", $phone)->where("id", "!=", $user->id)->first();


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

        $user->username = $username;
        $user->email = $email;
        if($request->get("phone")){
            $user->phone = $phone;
        }
        $user->save();

        $person = Person::where("user_id", $user->id)->first();
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
            "message"=> "Yor profile has been changed !!",
            "data"=> [
                "user"=> $user,
                "person"=> $person
            ]
        ], 200);
    }

}
