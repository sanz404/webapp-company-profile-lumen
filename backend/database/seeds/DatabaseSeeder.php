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
use App\Models\CategoryFaq;
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
        // $this->createOthers();
        // $this->createCountries();
        // $this->createUsers();
        // $this->createContacts();
        // $this->createNotification();
        // $this->creatArticles();
        // $this->createContent();
        // $this->createFaqs();
        $this->createFeature();
    }

    private function createFeature(){

        $data = array(
            array(
                "icon"=> "bi bi-collection",
                "title"=> "Featured title",
                "description"=> "Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.",
                "is_published"=> 1
            ),
            array(
                "icon"=> "bi bi-building",
                "title"=> "Featured title",
                "description"=> "Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.",
                "is_published"=> 1
            ),
            array(
                "icon"=> "bi bi-toggles2",
                "title"=> "Featured title",
                "description"=> "Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.",
                "is_published"=> 1
            ),
            array(
                "icon"=> "bi bi-toggles2",
                "title"=> "Featured title",
                "description"=> "Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.",
                "is_published"=> 1
            )
        );

        foreach($data as $row){
            Feature::create($row);
        }
    }

    private function createFaqs(){
        $data = array(
            array(
                "question"=> "Accordion Item #1",
                "answer"=> "This is the first item's accordion body. It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the .accordion-body , though the transition does limit overflow."
            ),
            array(
                "question"=> "Accordion Item #2",
                "answer"=> "This is the second item's accordion body. It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the .accordion-body , though the transition does limit overflow."
            ),
            array(
                "question"=> "Accordion Item #3",
                "answer"=> "This is the third item's accordion body. It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the .accordion-body , though the transition does limit overflow."
            )
        );
        $categories = CategoryFaq::all();
        foreach($categories as $category){
            $sort = 1;
            foreach($data as $row){
                Faq::create([
                    "question"=> $row["question"],
                    "answer"=> $row["answer"],
                    "sort"=> $sort,
                    "is_published"=> 1,
                    "category_id"=> $category->id
                ]);
                $sort++;
            }
        }
    }

    private function createContent(){
        $json_contents = file_get_contents(storage_path("json/contents.json"));
        $contents = json_decode($json_contents, true);
        $data = $contents["RECORDS"];
        foreach($data as $row){
            $check_code = Content::where("key_name", $row["key_name"])->first();
            if(is_null($check_code)){
                Content::create([
                    "key_name"=> $row["key_name"],
                    "key_value"=> $row["key_value"]
                ]);
            }
        }
    }

    private function createOthers(){

        // about
        $abouts = array("Our founding", "Growth & beyond");
        foreach($abouts as $row){
            $faker = Faker::create();
            About::create([
                "title"=> $row,
                "decsription"=> $faker->text
            ]);
        }

        // category articles
        $category_articles = array("News", "Media");
        foreach($category_articles as $row){
            $faker = Faker::create();
            CategoryArticle::create([
                "title"=> $row,
                "decsription"=> $faker->text
            ]);
        }

        // category faqs
        $category_faqs = array("Account & Billing", "Website Issues");
        foreach($category_faqs as $row){
            $faker = Faker::create();
            CategoryFaq::create([
                "title"=> $row,
                "decsription"=> $faker->text
            ]);
        }

        // category products
        $category_products = array("Website", "Mobile Apps");
        foreach($category_products as $row){
            $faker = Faker::create();
            CategoryProduct::create([
                "title"=> $row,
                "decsription"=> $faker->text
            ]);
        }

        // category projects
        $category_projects = array("Personal", "Corporate", "Government");
        foreach($category_products as $row){
            $faker = Faker::create();
            CategoryProject::create([
                "title"=> $row,
                "decsription"=> $faker->text
            ]);
        }

    }


    private function toSlug($text){
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return $text;
    }

    private function creatArticles(){
        $max = 50;
        for($i = 1; $i <= $max; $i++){
            $faker = Faker::create();
            $user = User::where("is_admin", 1)->first();
            if(!is_null($user)){
                $title = $faker->sentence;
                if(strlen($title) <= 64){
                    $slug = $this->toSlug($title);
                    $article = Article::where("slug", $slug)->first();
                    if(is_null($article)){
                        $formData = array(
                            "user_id"=> $user->id,
                            "slug"=> $slug,
                            "title"=> $title,
                            "content"=> $faker->paragraph(10),
                            "is_published"=> 1
                        );
                        $newArticle = Article::create($formData);
                        $categories = CategoryArticle::inRandomOrder()->take(1)->get()->pluck("id")->toArray();
                        if(count($categories) > 0){
                            $newArticle->Categories()->sync($categories);
                        }
                    }
                }
            }
        }
    }


    private function createNotification(){
        $max = 100;
        for($i = 1; $i <= $max; $i++){
            $faker = Faker::create();
            $user = User::inRandomOrder()->first();
            if(!is_null($user)){
                $notifiaction = array(
                    "user_id"=> $user->id,
                    "subject"=> $faker->company,
                    "sort_content"=> $faker->sentence,
                    "full_content"=> $faker->text,
                );
                Notification::create($notifiaction);
            }
        }
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
