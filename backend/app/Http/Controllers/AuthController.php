<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Utils\MailSend;
// load models
use App\Models\User;
use App\Models\EmailVerification;


class AuthController extends BaseController
{
    public function login(Request $request){

        $credential = $request->get("credential");
        if(!$credential){
            return response()->json(['message' => 'The credential field is required. !!'], 401);
        }

        $password = $request->get("password");
        if(!$password){
            return response()->json(['message' => 'The password field is required. !!'], 401);
        }

        $is_admin = $request->get("is_admin") ? true : false;

        $user = User::where("username", $credential)->orWhere("email", $credential)->first();
        if(is_null($user)){
            return response()->json(['message' => 'These credentials do not match our records. !!'], 401);
        }


        $current_password = $user->password;
        $check_password = Hash::check($password, $current_password);

        if(!$check_password){
            return response()->json(['message' => 'These credentials do not match our records. !!'], 401);
        }

        $status = (int) $user->status;
        if($status == 0){
            return response()->json(['message' => 'You need to confirm your account. We have sent you an activation code, please check your email. !!'], 401);
        }

        $day_expired = env("APP_ENV") == 'production' ? 1 : 30;
        $expired = Carbon::now()->addDays($day_expired)->timestamp;
        $token = Auth::attempt(["email"=> $user->email, "password"=> $password], ['exp' => $expired]);

        $user->password_reset_token = null;
        $user->save();

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expired,
            'is_admin'=> $user->is_admin
        ], 200);
    }

    public function register(Request $request){

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

        $check_username = User::where("username", $username)->first();
        if(!is_null($check_username)){
            return response()->json(['message' => 'The username has already been taken. !!'], 401);
        }

        $check_email = User::where("email", $email)->first();
        if(!is_null($check_email)){
            return response()->json(['message' => 'The email has already been taken. !!'], 401);
        }

        // Create User
        $formUser = array(
            "username"=> $username,
            "email"=> $email,
            "password"=> Hash::make($password),
            "is_admin"=> 0,
            "status"=> 0
        );
        $newUser = User::create($formUser);

        // Send Email Confirm
        $faker = Faker::create();
        $code = $faker->uuid;
        $token = md5($code."".time());
        EmailVerification::create([
            "user_id"=> $newUser->id,
            "code"=> md5($code),
            "token"=> $token,
            "email_confirmed"=> 0,
            "phone_confirmed"=> 0,
            "is_expired"=> 0,
            "expired_at"=> date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        $sender = "admin@devel.com";
        $template = file_get_contents(storage_path("emails/email-confirm.mail"));
        $template = str_replace("[APP_NAME]", env("APP_NAME"), $template);
        $content  = str_replace("[TARGET_URL]", env("APP_FRONTEND")."/auth/email/confirm/".$token, $template);
        MailSend::SendData($email, "Email Confirmation", $sender, $content);

        $response = array(
            "message"=> "You need to confirm your account. We have sent you an activation code, please check your email. !!",
            "data"=> $newUser
        );
        return response()->json($response);

    }

    public function confirm(Request $request){

        $token = $request->get("token");
        if(!$token){
            return response()->json(['message' => 'The token field is required. !!'], 401);
        }

        $verification = EmailVerification::where("token", $token)->first();
        if(is_null($verification)){
            return response()->json(['message' => 'The token is invalid. !!'], 401);
        }

        $date_now = date("Y-m-d H:i:s");
        $date_expired = $verification->expired_at;

        $d1 = new \DateTime($date_now);
        $d2 = new \DateTime($date_expired);

        if($d2 <= $d1){
            return response()->json(['message' => 'The token is expired. !!'], 401);
        }

        $verification->email_confirmed = 1;
        $verification->is_expired = 1;
        $verification->expired_at = $date_now;
        $verification->save();

        $user = User::where("id", $verification->user_id)->first();
        $user->status = 1;
        $user->save();

        $response = array(
            "message"=> "Your e-mail is verified. You can now login.",
            "data"=> $user
        );
        return response()->json($response);


    }

    public function forgot_password(Request $request){

        $is_admin = $request->get("is_admin");
        $email = $request->get("email");
        if(!$email){
            return response()->json(['message' => 'The email field is required. !!'], 401);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'The email field must be a valid email address. !!'], 401);
        }

        $user = User::where("email", $email)->first();
        if(is_null($user)){
            return response()->json(['message' => "We can't find a user with that e-mail address. !!"], 401);
        }

        $faker = Faker::create();
        $uuid = $faker->uuid;
        $code = $faker->uuid;
        $token = md5($code."".time());

        $user->password_reset_token = $token;
        $user->save();

        // Send Email Forgot Password
        $sender = "admin@devel.com";
        $template = file_get_contents(storage_path("emails/email-forgot-password.mail"));
        $template = str_replace("[APP_NAME]", env("APP_NAME"), $template);
        $content  = str_replace("[TARGET_URL]", env("APP_FRONTEND")."/auth/email/reset/".$token, $template);
        MailSend::SendData($email, "Reset Password", $sender, $content);


         $response = array(
             "message"=> "We have e-mailed your password reset link!",
             "data"=> $user
         );
         return response()->json($response);


    }

    public function reset_password(Request $request){

        $email = $request->get("email");
        if(!$email){
            return response()->json(['message' => 'The email field is required. !!'], 401);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'The email field must be a valid email address. !!'], 401);
        }

        $user = User::where("email", $email)->first();
        if(is_null($user)){
            return response()->json(['message' => "We can't find a user with that e-mail address. !!"], 401);
        }

        $token = $request->get("token");
        if(!$token){
            return response()->json(['message' => 'The token field is required. !!'], 401);
        }

        if($token != $user->password_reset_token){
            return response()->json(['message' => 'The token is invalid. !!'], 401);
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

        $user->password = Hash::make($password);
        $user->password_reset_token = null;
        $user->save();

        $response = array(
            "message"=> "Your password has been reset!",
            "data"=> $user
        );
        return response()->json($response);

    }

    public function logout(Request $request){

        $user = \Auth::User();

        \Auth::guard('api')->logout();

        $response = array(
            'message' => 'Logout successfully !!',
            'data'=> $user
        );

        return response()->json($response, 200);
    }



}
