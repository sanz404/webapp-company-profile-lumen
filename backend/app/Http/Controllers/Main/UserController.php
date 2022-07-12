<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;
// load models
use App\Models\User;
use App\Models\Country;

class UserController extends AppController{

    public function list(Request $request){
        $postData = $request->all();
        $user = \Auth::User();
        $response = User::getAll($postData, $user->id);
        return response()->json($response);
    }

    public function create(Request $request){

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

        $password = $request->get("password");
        if(!$password){
            return response()->json(['message' => 'The password field is required. !!'], 401);
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

        $check_username = User::where("username", $username)->first();
        if(!is_null($check_username)){
            return response()->json(['message' => 'The username has already been taken. !!'], 401);
        }

        $check_email = User::where("email", $email)->first();
        if(!is_null($check_email)){
            return response()->json(['message' => 'The email has already been taken. !!'], 401);
        }

        if($request->get("phone")){
            $phone = $request->get("phone");
            $check_phone = User::where("phone", $phone)->first();
            if(!is_null($check_email)){
                return response()->json(['message' => 'The phone number has already been taken. !!'], 401);
            }
        }

        // Create User
        $formUser = array(
            "username"=> $username,
            "email"=> $email,
            "password"=> Hash::make($password),
            'country_id'=> $request->get("country_id"),
            'address1'=> $request->get("address1"),
            'address2'=> $request->get("address2"),
            'city'=> $request->get("city"),
            'zip_code'=> $request->get("zip_code"),
            'phone'=> $request->get("phone") ? $request->get("phone") : null,
            "is_admin"=> 0,
            "status"=> 1
        );
        $newUser = User::create($formUser);

        $response = array(
            "message"=> "Data has been created !",
            "data"=> $newUser
        );
        return response()->json($response);

    }

    public function detail($id){
        $user = User::where("users.id", $id)
            ->select(["users.*", "countries.name as country_name"])
            ->leftJoin("countries", "countries.id", "users.country_id")
            ->first();

        if(is_null($user)){
            return abort(404);
        }

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $user
        );
        return response()->json($response);
    }

    public function update($id, Request $request){

        $user = User::where("id", $id)->first();
        if(is_null($user)){
            return abort(404);
        }


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

        if($request->get("password")){

            $password = $request->get("password");
            if(!$password){
                return response()->json(['message' => 'The password field is required. !!'], 401);
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

        $user->email = $request->get("email");
        $user->username = $request->get("username");
        $user->country_id = $request->get("country_id");
        $user->username = $request->get("username");
        $user->email = $request->get("email");
        $user->address1 = $request->get("address1");
        $user->address2 = $request->get("address2");
        $user->city = $request->get("city");
        $user->zip_code = $request->get("zip_code");

        if($request->get("password")){
            $user->password = Hash::make($password);
        }
        $user->save();

        $response = array(
            "message"=> "Data has been created !",
            "data"=> $user
        );
        return response()->json($response);

    }

    public function delete($id){

        $user = User::where("id", $id)->first();

        if(is_null($user)){
            return abort(404);
        }

        User::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $user
        );

        return response()->json($response);
    }

}
