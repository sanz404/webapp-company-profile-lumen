<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Message;

class MessageController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            "created_at",
            'full_name',
            'email',
            'phone',
            'message'
        );
        $data = DataTable::build($postData, $columns, Message::class);
        return response()->json($data);
    }

    public function detail($id){

        $data = Message::where("id", $id)->first();
        if(is_null($data)){
            return abort(404);
        }

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $data
        );
        return response()->json($response);
    }
}
