<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Team;

class TeamController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'image',
            'name',
            'position',
            'description',
            'is_published'
        );
        $data = DataTable::build($postData, $columns, Team::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $imagePath = null;
        if($request->get("image")){
            $uuid = $this->getUUID();
            $image = $request->get("image");
            $imagePath = $this->save_base64_image($image, $uuid, $this->getPublicPath("uploads/"));
        }


        $data = new Team;
        $data->name = $request->get("name");
        $data->position = $request->get("position");
        $data->description = $request->get("description");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;

        if(!is_null($imagePath)){
            $data->image = $imagePath;
        }

        $data->save();

        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = Team::where("id", $id)->first();
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


        $data = Team::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        $imagePath = $data->image;
        if($request->get("image")){
            $uuid = $this->getUUID();
            $image = $request->get("image");
            $fileUploaded = $this->save_base64_image($image, $uuid, $this->getPublicPath("uploads/"));
            if(!is_null($fileUploaded)){
                $imagePath = $fileUploaded;
                // delete old files
                if(file_exists($this->getPublicPath("uploads/".$data->image))){
                    @unlink($this->getPublicPath("uploads/".$data->image));
                }
            }
        }


        $data->name = $request->get("name");
        $data->position = $request->get("position");
        $data->description = $request->get("description");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->image = $imagePath;
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Team::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Team::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
