<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\AppController;
use Illuminate\Http\Request;
use App\Utils\DataTable;
// load models
use App\Models\Article;
use App\Models\User;
use App\Models\Contact;
use App\Models\Project;

class DashboardController extends AppController{

    public function content(){
        $data = array(
            "total_article"=> Article::count(),
            "total_user"=> User::count(),
            "total_project"=> Project::count(),
            "total_contact"=> Contact::count(),
        );
        return response()->json($data);
    }

}
