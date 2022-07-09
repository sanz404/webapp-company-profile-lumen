<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Contact;

class ContactController extends AppController{


    public function list(Request $request){
        $postData = $request->all();
        $columns = array(
            "id",
            'name',
            'email',
            'phone',
            'website',
            'address'
        );
        $data = DataTable::build($postData, $columns, Contact::class);
        return response()->json($data);
    }

    public function create(Request $request){

        $contact = new Contact;
        $contact->name = $request->get("name");
        $contact->email = $request->get("email");
        $contact->phone = $request->get("phone");
        $contact->website = $request->get("website");
        $contact->address = $request->get("address");
        $contact->save();

        $response = array(
            "message"=> "Data has been created !",
            "data"=> $contact
        );
        return response()->json($response);

    }

    public function detail($id){

        $contact = Contact::where("id", $id)->first();
        if(is_null($contact)){
            return abort(404);
        }

        $response = array(
            "message"=> "Data has been founded !",
            "data"=> $contact
        );
        return response()->json($response);
    }

    public function update($id, Request $request){

        $contact = Contact::where("id", $id)->first();

        if(is_null($contact)){
            return abort(404);
        }

        $contact->name = $request->get("name");
        $contact->email = $request->get("email");
        $contact->phone = $request->get("phone");
        $contact->website = $request->get("website");
        $contact->address = $request->get("address");
        $contact->save();

        $response = array(
            "message"=> "Data has been updated !",
            "data"=> $contact
        );
        return response()->json($response);

    }

    public function delete($id){

        $contact = Contact::where("id", $id)->first();

        if(is_null($contact)){
            return abort(404);
        }

        Contact::where("id", $id)->delete();
        $response = array(
            "message"=> "Data has been deleted !",
            "data"=> $contact
        );

        return response()->json($response);
    }



}
