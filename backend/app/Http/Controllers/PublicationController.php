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

class PublicationController extends AppController{

    public function getHomeArticle(){

        $data = array();
        $articles = Article::where("is_published", 1)->take(3)->orderBy("id", "DESC")->get();

        foreach($articles as $row){
            $row->content = $this->first_sentence(strip_tags($row->content));
            $row->author = User::where("id", $row->user_id)->first();
            $row->date_created = $row->created_at->diffForHumans();
            $data[]  = array(
                "detail"=> $row,
                "categories"=> $row->Categories()->pluck("name")->toArray(),
                "imageAuthor"=> "https://www.kindpng.com/picc/m/269-2697881_computer-icons-user-clip-art-transparent-png-icon.png"
            );
        }

        return response()->json($data);
    }

    public function getFeature(){
        $data = Feature::where("is_published", 1)->get();
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


}
