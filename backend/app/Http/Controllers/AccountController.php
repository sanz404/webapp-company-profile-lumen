<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Models\User;

class AccountController extends AppController{

    public function getCountries(){
        $countries = Country::select(["id as code", "name as label"])->orderBy("name")->get();
        $response = array(
            "data"=> $countries
        );
        return response()->json($response);
    }

    public function updateAuthUser(Request $request){

        $user = \Auth::User();

        $username = $request->get("username");
        if(!$username){
            return response()->json(['message' => 'The username field is required. !!'], 401);
        }

        $email = $request->get("email");
        if(!$email){
            return response()->json(['message' => 'The email field is required. !!'], 401);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'The email field must be a valid email address. !!'], 401);
        }

        $check_username = User::where("username", $username)->where("id", "!=", $user->id)->first();
        if(!is_null($check_username)){
            return response()->json(['message' => 'The username has already been taken. !!'], 401);
        }

        $check_email = User::where("email", $email)->where("id", "!=", $user->id)->first();
        if(!is_null($check_email)){
            return response()->json(['message' => 'The email has already been taken. !!'], 401);
        }

        if($request->get("phone")){
            $phone = $request->get("phone");
            $check_phone = User::where("phone", $phone)->where("id", "!=", $user->id)->first();
            if(!is_null($check_email)){
                return response()->json(['message' => 'The phone number has already been taken. !!'], 401);
            }
            $user->phone = $request->get("phone");
        }

        $user->country_id = $request->get("country_id");
        $user->username = $request->get("username");
        $user->email = $request->get("email");
        $user->address1 = $request->get("address1");
        $user->address2 = $request->get("address2");
        $user->city = $request->get("city");
        $user->zip_code = $request->get("zip_code");
        $user->save();

        $response = array(
            "message"=> "Your account has been updated!",
            "data"=> $user
        );
        return response()->json($response);
    }

    public function getAuthUser(Request $request){
        $user = \Auth::User();
        $user->country = Country::where("id", $user->country_id)->first();
        $response = array(
            "data"=> $user
        );
        return response()->json($response);
    }

    public function passwordUpdate(Request $request){

        $user = \Auth::User();

        $password_old = $request->get("password_old");
        if(!$password_old){
            return response()->json(['message' => 'The old password field is required. !!'], 401);
        }

        $password = $request->get("password");
        if(!$password){
            return response()->json(['message' => 'The password field is required. !!'], 401);
        }

        $password_confirm = $request->get("password_confirm");
        if(!$password_confirm){
            return response()->json(['message' => 'The password confirm field is required. !!'], 401);
        }

        if($password != $password_confirm){
            return response()->json(['message' => 'The password confirmation does not match. !!'], 401);
        }

        if(strlen($password) < 8){
            return response()->json(['message' => 'The password must be at least 8. !!'], 401);
        }

        if (!preg_match("#[0-9]+#", $password)) {
            return response()->json(['message' => 'The password must have a number.!!'], 401);
        }

        if (!preg_match("#[a-zA-Z]+#", $password)) {
            return response()->json(['message' => 'The password must have a string.!!'], 401);
        }

        $current_password = $user->password;
        $check_password = Hash::check($password_old, $current_password);

        if(!$check_password){
            return response()->json(['message' => 'These credentials do not match our records. !!'], 401);
        }

        $user->password = Hash::make($password);
        $user->save();

        $response = array(
            "message"=> "Your password has been reset!",
            "data"=> $user
        );
        return response()->json($response);

    }

}
