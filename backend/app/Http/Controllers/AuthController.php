<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Faker\Factory as Faker;
use App\Models\Auth\User;
use App\Models\Auth\Person;
use App\Models\Auth\PasswordReset;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register', 'confirm', 'forgotPassword', 'resetPassword', 'logout']]);
    }

    public function refreshtoken(Request $request)
    {
         $token = auth()->fromUser(auth()->user());
         $userLogged = auth()->user();
         $person = Person::where("user_id", $userLogged->id)->first();
         $startTime = date("Y-m-d H:i:s.u");
         $time_expired = auth()->factory()->getTTL() * 24; // one days
         $cenvertedTime = strtotime('+0 hour +'.$time_expired.' minutes',strtotime($startTime));
         return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user(),
                'person'=> $person,
                'token_expired' => $cenvertedTime
            ]
        ], 200);
    }

    public function login(Request $request)
    {

        if(!$request->get("credential")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'credential' can not be empty!",
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

        $credential = $request->get("credential");
        $password = $request->get("password");
        $is_admin = $request->get("is_admin") ? $request->get("is_admin") : 0;

        $user = User::where("username", $credential)->orWhere("email", $credential)->first();
        if(is_null($user)){
            return response()->json([
                "status"=> false,
                "message"=> "These credentials do not match our records.",
                "data"=> null
            ], 400);
        }

        if($user->is_admin != $is_admin){
            return response()->json([
                "status"=> false,
                "message"=> "These credentials do not match our records.",
                "data"=> null
            ], 400);
        }

        $hashedPassword = $user->password;
        if (!Hash::check($password, $hashedPassword)) {
            return response()->json([
                "status"=> false,
                "message"=> "Incorrect password please try again !!",
                "data"=> null
            ], 400);
        }

        $is_banned = (int) $user->is_banned;
        $verified = (int) $user->verified;

        if($is_banned == 1){
            return response()->json([
                "status"=> false,
                "message"=> "Your account has been suspend, please contact administrator!!",
                "data"=> null
            ], 400);
        }

        if($verified == 0){
            return response()->json([
                "status"=> false,
                "message"=> "You need to confirm your account. We have sent you an activation code, please check your email.!",
                "data"=> null
            ], 400);
        }

        $token = Auth::login($user);
        $userLogged = auth()->user();
        $person = Person::where("user_id", $userLogged->id)->first();
        $startTime = date("Y-m-d H:i:s.u");
        $time_expired = auth()->factory()->getTTL(); // one days
        $cenvertedTime = date('Y-m-d H:i:s.u', strtotime("+".$time_expired." min"));

        return response()->json([
            "status"=> true,
            "message"=> "",
            "data"=> [
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => auth()->user(),
                'person'=> $person,
                'token_expired' => $cenvertedTime
            ]
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function register(Request $request)
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

        if(!$request->get("password_confirm")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'password_confirm' can not be empty!",
                "data"=> null
            ], 400);
        }

        $username =  $request->get("username");
        $email =  $request->get("email");
        $password =  $request->get("password");
        $password_confirm =  $request->get("password_confirm");

        if(strlen($password) < 8){
            return response()->json([
                "status"=> false,
                "message"=> "The password must be at least 8 characters.!",
                "data"=> null
            ], 400);
        }

        if($password != $password_confirm){
            return response()->json([
                "status"=> false,
                "message"=> "The password confirmation does not match.!",
                "data"=> null
            ], 400);
        }

        $checkUserName = User::where("username", $username)->first();
        $checkUserEmail = User::where("email", $email)->first();

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

        $faker = Faker::create();
        $user = new User;
        $user->username = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->is_admin = 0;
        $user->is_banned = 0;
        $user->verified = 0;
        $user->verification_token = md5($faker->uuid);
        $user->save();

        Person::create(["user_id"=> $user->id]);

        return response()->json([
            "status"=> true,
            "message"=> "You need to confirm your account. We have sent you an activation code, please check your email.!",
            "data"=> [
                "verification_token"=> $user->verification_token
            ]
        ], 200);

    }

    public function confirm($token)
    {
        if(is_null($token)){
            return response()->json([
                "status"=> false,
                "message"=> "Invalid token !",
                "data"=> null
            ], 400);
        }

        $user = User::where("verification_token", $token)->where("verified", 0)->first();
        if(is_null($user)){
            return response()->json([
                "status"=> false,
                "message"=> "We can't find a user with that  token is invalid.!",
                "data"=> null
            ], 400);
        }

        $user->verified = 1;
        $user->verification_token = null;
        $user->save();

        return response()->json([
            "status"=> true,
            "message"=> "Your e-mail is verified. You can now login.",
            "data"=> null
        ], 200);

    }

    public function forgotPassword(Request $request)
    {
        if(!$request->get("email")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'email' can not be empty!",
                "data"=> null
            ], 400);
        }

        $email = $request->get("email");
        $user = User::where("email", $email)->first();

        if(is_null($user)){
            return response()->json([
                "status"=> false,
                "message"=> "We can't find a user with that e-mail address.",
                "data"=> null
            ], 400);
        }


        $faker = Faker::create();
        $token = md5($faker->uuid);
        PasswordReset::where("email", $email)->delete();
        PasswordReset::create([
            "email"=> $email,
            "token"=> $token,
            "created_at"=> date("Y-m-d H:i:s")
        ]);

        return response()->json([
            "status"=> true,
            "message"=> "We have e-mailed your password reset link!",
            "data"=> ["token"=> $token]
        ], 200);

    }

    public function resetPassword($token, Request $request)
    {
        if(is_null($token)){
            return response()->json([
                "status"=> false,
                "message"=> "Invalid token !",
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

        if(!$request->get("password_confirm")){
            return response()->json([
                "status"=> false,
                "message"=> "The field 'password_confirm' can not be empty!",
                "data"=> null
            ], 400);
        }

        $email =  $request->get("email");
        $password =  $request->get("password");
        $password_confirm =  $request->get("password_confirm");

        if(strlen($password) < 8){
            return response()->json([
                "status"=> false,
                "message"=> "The password must be at least 8 characters.!",
                "data"=> null
            ], 400);
        }

        if($password != $password_confirm){
            return response()->json([
                "status"=> false,
                "message"=> "The password confirmation does not match.!",
                "data"=> null
            ], 400);
        }

        $checkUser = PasswordReset::where("email", $email)->where("token", $token)->first();
        if(is_null($checkUser)){
            return response()->json([
                "status"=> false,
                "message"=> "We can't find a user with that e-mail address or password reset token is invalid.!",
                "data"=> null
            ], 400);
        }

        $user = User::where("email", $email)->first();
        $user->password = Hash::make($password);
        $user->verified = 1;
        $user->verification_token = null;
        $user->save();

        PasswordReset::where("email", $email)->delete();

        return response()->json([
            "status"=> true,
            "message"=> "Your password has been reset!",
            "data"=> null
        ], 200);

    }

}
