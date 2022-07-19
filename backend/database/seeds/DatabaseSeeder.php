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
use App\Models\Team;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    const DEFAULT_ADMIN_USERNAME = "admin";
    const DEFAULT_ADMIN_EMAIL = "admin@devel.com";

    public function run()
    {
        $this->command->warn('Begin instalation, please wait...');

        $this->resetTable();
        $this->createOthers();
        $this->createCountries();
        $this->createUsers();
        $this->createContacts();
        $this->createNotification();
        $this->creatArticles();
        $this->createContent();
        $this->createFaqs();
        $this->createFeature();
        $this->createMessage();
        $this->createProduct();
        $this->createProject();
        $this->createTeam();

        $admin = User::where("is_admin", 1)->first();
        if(!is_null($admin)){

            $this->command->info('-----------------------------------------');
            $this->command->info('Admin Username : '.self::DEFAULT_ADMIN_USERNAME);
            $this->command->info('Admin Email : '.self::DEFAULT_ADMIN_EMAIL);
            $this->command->info('Admin Password : 5ecReT!');
            $this->command->info('-----------------------------------------');
        }

        $this->command->warn('Instalaation has been finished :)');
    }

    private function resetTable(){
        About::truncate();
        Article::truncate();
        ArticleComment::truncate();
        CategoryArticle::truncate();
        CategoryProduct::truncate();
        CategoryProject::truncate();
        CategoryFaq::truncate();
        Content::truncate();
        Contact::truncate();
        Country::truncate();
        EmailVerification::truncate();
        Faq::truncate();
        Feature::truncate();
        Message::truncate();
        Notification::truncate();
        Product::truncate();
        Project::truncate();
        Team::truncate();
        User::truncate();
    }

    private function createTeam(){

        $faker = Faker::create();

        $data = array(
            array(
                "name"=> "Ibbie Eckart",
                "position"=> "Founder & CEO",
                "description"=> $faker->text,
                "is_published"=> 1
            ),
            array(
                "name"=> "Arden Vasek",
                "position"=> "CFO",
                "description"=> $faker->text,
                "is_published"=> 1
            ),
            array(
                "name"=> "Toribio Nerthus",
                "position"=> "Operations Manager",
                "description"=> $faker->text,
                "is_published"=> 1
            ),
            array(
                "name"=> "Malvina Cilla",
                "position"=> "CTO",
                "description"=> $faker->text,
                "is_published"=> 1
            )
        );

        foreach($data as $row){
            Team::create($row);
        }
    }

    private function createProject(){
        for($i = 1; $i <= 4; $i++){
            $category = CategoryProject::inRandomOrder()->first();
            Project::create([
                "category_id"=> $category->id,
                "name"=> "Project ".$i,
                "description"=> "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.",
                "is_published"=> 1
            ]);
        }
    }

    private function createProduct(){
        $category = CategoryProduct::inRandomOrder()->first();
        $data = array(
            array(
                "category_id"=> $category->id,
                "name"=> "FREE",
                "price"=> 0,
                "description"=> "<ul><li><strong>1 users</strong></li><li>5GB storage</li><li>Unlimited public projects</li><li>Community access</li><li>Unlimited private projects</li><li>Dedicated support</li><li>Free linked domain</li><li>Monthly status reports</li></ul>",
                "is_published"=> 1
            ),
            array(
                "category_id"=> $category->id,
                "name"=> "PRO",
                "price"=> 9,
                "description"=> "<ul><li><strong>5 users</strong></li><li>5GB storage</li><li>Unlimited public projects</li><li>Community access</li><li>Unlimited private projects</li><li>Dedicated support</li><li>Free linked domain</li><li>Monthly status reports</li></ul>",
                "is_published"=> 1
            ),
            array(
                "category_id"=> $category->id,
                "name"=> "ENTERPRISE",
                "price"=> 49,
                "description"=> "<ul><li><strong>Unlimited users</strong></li><li>5GB storage</li><li>Unlimited public projects</li><li>Community access</li><li>Unlimited private projects</li><li>Dedicated support</li><li><strong>Unlimited</strong> linked domains</li><li>Monthly status reports</li></ul>",
                "is_published"=> 1
            )
        );

        foreach($data as $row){
            Product::create($row);
        }

    }

    private function createMessage(){
        for($i = 1; $i <= 100; $i++){
            $faker = Faker::create();
            Message::create([
                "full_name"=> $faker->name,
                "email"=> $faker->email,
                "phone"=> $faker->phoneNumber,
                "message"=> $faker->text
            ]);
        }
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
                "description"=> $faker->text
            ]);
        }

        // category articles
        $category_articles = array("News", "Media");
        foreach($category_articles as $row){
            $faker = Faker::create();
            CategoryArticle::create([
                "name"=> $row,
                "description"=> $faker->text
            ]);
        }

        // category faqs
        $category_faqs = array("Account & Billing", "Website Issues");
        foreach($category_faqs as $row){
            $faker = Faker::create();
            CategoryFaq::create([
                "name"=> $row,
                "description"=> $faker->text
            ]);
        }

        // category products
        $category_products = array("Website", "Mobile Apps");
        foreach($category_products as $row){
            $faker = Faker::create();
            CategoryProduct::create([
                "name"=> $row,
                "description"=> $faker->text
            ]);
        }

        // category projects
        $category_projects = array("Personal", "Corporate", "Government");
        foreach($category_products as $row){
            $faker = Faker::create();
            CategoryProject::create([
                "name"=> $row,
                "description"=> $faker->text
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
