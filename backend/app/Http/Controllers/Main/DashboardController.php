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
use App\Models\CategoryProject;

class DashboardController extends AppController{

    public function content(){
        $data = array(
            "total_article"=> Article::count(),
            "total_user"=> User::count(),
            "total_project"=> Project::count(),
            "total_contact"=> Contact::count(),
            "bar_chart"=>$this->getBarChart(),
            "pie_chart"=>$this->getPieChart()
        );
        return response()->json($data);
    }

    private function getBarChart(){

        $datas = array();
        for($i = 1; $i <=12; $i++){
            $last_date = cal_days_in_month(CAL_GREGORIAN, $i, date("Y"));
            $month = $i > 9 ? $i : "0".$i;
            $date_first = date("Y-".$month."-01");
            $date_last = date("Y-".$month."-".$last_date);
            $datas[] = Article::where("created_at", ">=", $date_first)->where("created_at", "<=", $date_last)->count();
        }

        return array(
            "labels"=> ['JAN', 'FEB', 'MAR' ,'APR', 'MAY', 'JUN', 'JUL', 'AGS', 'SEP', 'OCT', 'NOV', 'DESC'],
            "datasets"=> array(
               array(
                    "label"=> "Total Article",
                    "data"=> $datas
               )
            )
        );
    }

    private function getPieChart(){

        $labels = array();
        $data = array();
        $colors = array();

        $categories = CategoryProject::where("id", "<>", 0)->orderBy("name")->get();
        foreach($categories as $category){
            $total_project = Project::where("category_id", $category->id)->count();
            if($total_project > 0){
                $labels[] = $category->name;
                $data[] = $total_project;
                $colors[] = $this->getRandomColor();
            }
        }


        return array(
            "labels"=> $labels,
            "datasets"=> array(
                array(
                    "backgroundColor"=>$colors,
                    "data"=> $data
                )
            )
        );
    }

}
