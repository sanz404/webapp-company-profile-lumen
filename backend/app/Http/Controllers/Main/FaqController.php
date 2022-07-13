<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Faq;

class FaqController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'question',
            'answer',
            'sort',
            'is_published'
        );
        $data = DataTable::build($postData, $columns, Faq::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $data = new Faq;
        $data->question = $request->get("question");
        $data->answer = $request->get("answer");


        if($request->get("sort")){
            $data->sort = $request->get("sort");
        }

        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->save();
        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = Faq::where("id", $id)->first();
        if(is_null($data)){
            return abort(404);
        }

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $data
        );
        return response()->json($response);
    }

    public function update($id, Request $request){

        $data = Faq::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        $data->question = $request->get("question");
        $data->answer = $request->get("answer");

        if($request->get("sort")){
            $data->sort = $request->get("sort");
        }

        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Faq::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Faq::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
