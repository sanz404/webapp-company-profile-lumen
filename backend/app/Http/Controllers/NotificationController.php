<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
// load models
use App\Models\Notification;

class NotificationController extends AppController{


    public function detail($id){

        $user = \Auth::User();
        $notification = Notification::where("id", $id)->where("user_id", $user->id)->first();

        if(is_null($notification)){
            return abort(404);
        }

        $notification->readed_at = date('Y-m-d H:i:s');
        $notification->save();

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $notification
        );
        return response()->json($response);

    }

    public function current(){
        $user = \Auth::User();
        $total_unread = Notification::where("user_id", $user->id)->where("readed_at", null)->count();
        $list_notif =  Notification::where("user_id", $user->id)->where("readed_at", null)->take(3)->orderBy("id", "DESC")->get();
        $response = array(
            "message"=> "Data has been founded !",
            "data"=> array(
                "total_unread"=> $total_unread,
                "list_notif"=> $list_notif
            )
        );
        return response()->json($response);
    }

    public function list(Request $request){
        $postData = $request->all();
        $user = \Auth::User();
        $response = Notification::getAll($postData, $user->id);
        return response()->json($response);
    }

    public function delete($id){

        $user = \Auth::User();
        $notification = Notification::where("id", $id)->where("user_id", $user->id)->first();

        if(is_null($notification)){
            return abort(404);
        }

        Notification::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $notification
        );

        return response()->json($response);
    }


}
