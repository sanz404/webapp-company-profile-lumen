<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\CategoryFaq;

class CategoryFaqController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'name',
            'description'
        );
        $data = DataTable::build($postData, $columns, CategoryFaq::class);
        return response()->json($data);
    }

    public function create(Request $request){
        $data = new CategoryFaq;
        $data->name = $request->get("name");
        $data->description = $request->get("description");
        $data->save();
        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = CategoryFaq::where("id", $id)->first();
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

        $data = CategoryFaq::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        $data->name = $request->get("name");
        $data->description = $request->get("description");
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = CategoryFaq::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        CategoryFaq::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
