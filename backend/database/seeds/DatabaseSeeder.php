<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\About;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\CategoryArticle;
use App\Models\CategoryProduct;
use App\Models\CategoryProject;
use App\Models\Content;
use App\Models\Contact;
use App\Models\Country;
use App\Models\EmailVerification;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Team;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->createCountries();
        $this->createUsers();
        $this->createContacts();
    }

    private function createContacts(){
        for($i = 1; $i <= 100; $i++){
            $faker = Faker::create();
            $formData = array(
                'name'=> $faker->city,
                'email'=> $faker->email,
                'phone'=> $faker->phoneNumber,
                'website'=> $faker->freeEmailDomain,
                'address'=> $faker->streetAddress
            );
            Contact::create($formData);
        }
    }

    private function createCountries(){
        $json_countries = file_get_contents(storage_path("json/countries.json"));
        $countries = json_decode($json_countries, true);
        foreach($countries["ref_country_codes"] as $country){
            $item = $country;
            $items = array(
                'code'=> $item["alpha2"],
                'name'=> $item["country"]
            );
            $check_code = Country::where("code", $item["alpha2"])->first();
            if(is_null($check_code)){
                Country::create($items);
            }
        }
    }

    private function createUsers(){
        $max = 100;
        for($i = 1; $i <= $max; $i++){
            $faker = Faker::create();
            $username = $i == 1 ? "admin" : $faker->userName;
            $email = $i == 1 ? "admin@devel.com" : $faker->safeEmail;
            $password = "5ecReT!";
            $country = Country::inRandomOrder()->first();
            $user = array(
                "country_id"=> $country->id,
                "username"=> $username,
                "email"=> $email,
                "phone"=> $faker->phoneNumber,
                "address1"=> $faker->streetAddress,
                "address2"=> $faker->streetAddress,
                "city"=> $faker->city,
                "zip_code"=> $faker->postcode,
                "password"=> Hash::make($password),
                "password_reset_token"=> md5($faker->uuid),
                "is_admin"=> $i == 1 ? 1 : 0,
                "status"=> 1,
            );
            $check_username = User::where("username", $username)->first();
            $check_email = User::where("email", $email)->first();
            if(is_null($check_username) || is_null($check_email)){
                User::create($user);
            }
        }
    }

}
