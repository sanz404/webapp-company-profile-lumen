<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
// load models
use App\Models\Message;
use App\Models\Content;
use App\Models\Feature;

class PublicationController extends AppController{

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
