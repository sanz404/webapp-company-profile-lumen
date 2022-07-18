<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
// load models
use App\Models\Message;
use App\Models\Content;
use App\Models\Feature;
use App\Models\Article;
use App\Models\User;
use App\Models\About;
use App\Models\Team;
use App\Models\Faq;
use App\Models\CategoryFaq;
use App\Models\Product;
use App\Models\Project;
use App\Models\ArticleComment;
use App\Models\CategoryArticle;

class PublicationController extends AppController{

    public function getCategories(){
        $data = CategoryArticle::orderBy("name")->get();
        return response()->json($data);
    }

    public function getListArticle(Request $request){

        $limit =  $request->get("limit");
        $offset =  $request->get("offset");

        $data = Article::where("is_published", 1);

        $category = array();
        if($request->get("category_id")){
            $category = CategoryArticle::where("id",$request->get("category_id"))->first();
            if(!is_null($category)){
                $article_id = $category->Articles()->get()->pluck("id")->toArray();
                if(count($article_id) > 0){
                    $data = $data->whereIn("id", $article_id);
                }
            }
        }

        $filtered = false;
        if($request->get("search")){
            $filtered = true;
            $searchValue = $request->get("search");
            $data = $data->where("title", 'LIKE', '%' . $searchValue . '%')->orWhere("content", 'LIKE', '%' . $searchValue . '%');
        }

        $totalFiltered = $data->count();
        $data = $data->skip($offset)->take($limit)->orderBy("id", "DESC")->get();

        foreach($data as $row){
            $row->date_created = $row->created_at->diffForHumans();
            $row->content = $this->first_sentence(strip_tags($row->content));
        }

        $response = array(
            "data"=> $data,
            "total_records"=> $filtered ? $totalFiltered : Article::where("is_published", 1)->count()
        );

        return response()->json($response);
    }

    public function getArticleBySlug($slug){

        $data = Article::where("slug", $slug)->first();

        if(is_null($data)){
            return response()->json(['message' => 'Data not found. !!'], 400);
        }

        $user = User::where("id", $data->user_id)->first();

        $comments = ArticleComment::where("articles_comments.article_id", $data->id)
            ->select(["articles_comments.*", "users.email"])
            ->join("users", "users.id", "articles_comments.user_id")
            ->orderBy("articles_comments.id", "DESC")
            ->get();

        foreach($comments as $comment){
            $comment->date_created = $comment->created_at->diffForHumans();
        }

        $data->author =  $user;
        $data->date_joined = $user->created_at->diffForHumans();
        $data->date_created = $data->created_at->diffForHumans();
        $data->categories = $data->Categories()->get();
        $data->comments = $comments;
        return response()->json($data);
    }

    public function getHomeArticle(){

        $data = array();
        $articles = Article::where("is_published", 1)->take(3)->orderBy("id", "DESC")->get();

        foreach($articles as $row){
            $row->content = $this->first_sentence(strip_tags($row->content));
            $row->author = User::where("id", $row->user_id)->first();
            $row->date_created = $row->created_at->diffForHumans();
            $data[]  = array(
                "detail"=> $row,
                "categories"=> $row->Categories()->pluck("name")->toArray()
            );
        }

        return response()->json($data);
    }

    public function getFaq(){

        $data = array();
        $categories = CategoryFaq::all();

        foreach($categories as $row){
            $data[] = array(
                "category_name"=> $row->name,
                "category_id"=> $row->id,
                "details"=> Faq::where("category_id", $row->id)->where("is_published", 1)->orderBy("sort")->get()
            );
        }

        return response()->json($data);
    }

    public function getAbout(){
        $data = About::where("is_published", 1)->orderBy("id", "DESC")->get();
        return response()->json($data);
    }

    public function getFeature(){
        $data = Feature::where("is_published", 1)->orderBy("id", "DESC")->get();
        return response()->json($data);
    }

    public function getTeam(){
        $data = Team::where("is_published", 1)->orderBy("id", "DESC")->get();
        return response()->json($data);
    }

    public function getProduct(){
        $data = Product::where("is_published", 1)->orderBy("price", "ASC")->get();
        return response()->json($data);
    }

    public function getProject(){
        $data = Project::where("is_published", 1)->orderBy("id", "DESC")->get();
        return response()->json($data);
    }

    public function getProjectById($id){
        $data = Project::where("id", $id)->first();
        $data->information = $this->first_sentence($data->description);
        return response()->json($data);
    }

    public function getContent(){
        $data = Content::where("id", "<>", 0)
            ->select(["key_name", "key_value"])
            ->orderBy("key_name")
            ->get();
        return response()->json($data);
    }

    public function sendContact(Request $request){
        $data = Message::create([
            "full_name"=> $request->get("full_name"),
            "email"=> $request->get("email"),
            "phone"=> $request->get("phone"),
            "message"=> $request->get("message")
        ]);
        return response()->json($data);
    }

    public function sendComment(Request $request){
        $user = \Auth::User();
        $user_id = $user->id;
        $slug = $request->get("slug");
        $article = Article::where("slug", $slug)->first();
        $data = ArticleComment::create([
            "user_id"=> $user_id,
            "article_id"=> $article->id,
            "description"=> $request->get("description")
        ]);
        return response()->json($data);
    }


}
