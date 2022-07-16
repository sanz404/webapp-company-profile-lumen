<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
// load models
use App\Models\Project;
use App\Models\CategoryProject;

class ProjectController extends AppController{

    public function categories(){
        $data = CategoryProject::where("id", "<>", 0)
            ->select(["id as code", "name as label"])
            ->orderBy("name")
            ->get();
        return response()->json($data);
    }


    public function list(Request $request){
        $postData = $request->all();
        $data = Project::getAllData($postData);
        return response()->json($data);
    }

    public function create(Request $request){

        $imagePath = null;
        if($request->get("image")){
            $uuid = $this->getUUID();
            $image = $request->get("image");
            $imagePath = $this->save_base64_image($image, $uuid, $this->getPublicPath("uploads/"));
        }

        $data = new Project;
        $data->name = $request->get("name");
        $data->category_id = $request->get("category_id");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->description = $request->get("description");

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

        $data = Project::where("id", $id)->first();
        if(is_null($data)){
            return abort(404);
        }

        $data->category = CategoryProject::where("id", $data->category_id)->first();

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $data
        );
        return response()->json($response);
    }

    public function update($id, Request $request){

        $data = Project::where("id", $id)->first();

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
        $data->category_id = $request->get("category_id");
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->description = $request->get("description");
        $data->image = $imagePath;
        $data->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Project::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Project::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
