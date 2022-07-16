<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Article;
use App\Models\CategoryArticle;

class ArticleController extends AppController{

    public function categories(){
        $data = CategoryArticle::where("id", "<>", 0)
            ->select(["id as code", "name as label"])
            ->orderBy("name")
            ->get();
        return response()->json($data);
    }


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'image',
            'title',
            'created_at',
            'is_published'
        );
        $data = DataTable::build($postData, $columns, Article::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $imagePath = null;
        if($request->get("image")){
            $uuid = $this->getUUID();
            $image = $request->get("image");
            $imagePath = $this->save_base64_image($image, $uuid, $this->getPublicPath("uploads/"));
        }

        $data = new Article;
        $data->user_id = \Auth::User()->id;
        $data->title = $request->get("title");
        $data->slug = $this->toSlug($request->get("title"));
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->content = $request->get("content");

        if(!is_null($imagePath)){
            $data->image = $imagePath;
        }

        $data->save();

        if($request->get("categories")){
            $categories = $request->get("categories");
            $data->Categories()->sync($categories);
        }

        $response = array(
            "message"=> "Data has been created !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function detail($id){

        $data = Article::where("id", $id)->first();
        if(is_null($data)){
            return abort(404);
        }

        $categories = array();
        $categoriesSelected = $data->Categories()->get();
        foreach($categoriesSelected as $row){
            $categories[] = array(
                "code"=> $row->id,
                "label"=> $row->name
            );
        }
        $data->categorySelected = $categories;
        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $data
        );
        return response()->json($response);
    }

    public function update($id, Request $request){

        $data = Article::where("id", $id)->first();

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

        $data->title = $request->get("title");
        $data->slug = $this->toSlug($request->get("title"));
        $data->is_published = $request->get("is_published") ? $request->get("is_published") : 0;
        $data->content = $request->get("content");
        $data->image = $imagePath;
        $data->save();

        if($request->get("categories")){
            $categories = $request->get("categories");
            $data->Categories()->sync($categories);
        }else{
            $data->Categories()->sync([]);
        }

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $data
        );
        return response()->json($response);

    }

    public function delete($id){

        $data = Article::where("id", $id)->first();

        if(is_null($data)){
            return abort(404);
        }

        Article::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $data
        );

        return response()->json($response);
    }



}
