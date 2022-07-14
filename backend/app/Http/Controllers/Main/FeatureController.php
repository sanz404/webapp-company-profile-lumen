<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Feature;

class FeatureController extends AppController{


    public function fontawesome(){
        $json = file_get_contents(storage_path("json/fontawesome.json"));
        $data = json_decode($json, true);
        $response = array();
        foreach($data as $row){
            $response[] = array(
                "code"=> $row,
                "label"=> $row,
            );
        }
        return response()->json($response);
    }

    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'icon',
            'title',
            'description',
            'is_published'
        );
        $data = DataTable::build($postData, $columns, Feature::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $data = new Feature;
        $data->icon = $request->get("icon");
        $data->title = $request->get("title");
        $data->description = $request->get("description");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->save();
        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = Feature::where("id", $id)->first();
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

        $data = Feature::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        $data->icon = $request->get("icon");
        $data->title = $request->get("title");
        $data->description = $request->get("description");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Feature::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Feature::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
