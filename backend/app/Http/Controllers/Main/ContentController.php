<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Content;

class ContentController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'key_name',
            'key_value'
        );
        $data = DataTable::build($postData, $columns, Content::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $key_name = $request->get("key_name");
        $key_slug = $this->toSlug($key_name);

        $check_exists = Content::where("key_name", $key_slug)->first();
        if(!is_null($check_exists)){
            return response()->json(['message' => 'The content name has already been taken. !!'], 401);
        }

        $data = new Content;
        $data->key_name = $key_slug;
        $data->key_value = $request->get("key_value");
        $data->save();
        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = Content::where("id", $id)->first();
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

        $key_name = $request->get("key_name");
        $key_slug = $this->toSlug($key_name);

        $check_exists = Content::where("key_name", $key_slug)->where("id", "!=", $id)->first();
        if(!is_null($check_exists)){
            return response()->json(['message' => 'The content name has already been taken. !!'], 401);
        }

        $data = Content::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        $data->key_name = $key_slug;
        $data->key_value = $request->get("key_value");
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Content::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Content::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
