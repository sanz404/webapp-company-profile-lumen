<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\CategoryProject;

class Project extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'projects';

    protected $fillable = [
        "category_id",
        "name",
        "image",
        "description",
        "is_published"
    ];

    public function Category(){
        return $this->belongsTo(CategoryProject::class, "category_id");
    }

    public static function getAllData($postData){
        $columns = array(
           "projects.id",
           "category_projects.name as category_name",
           "projects.image",
           "projects.name",
           "projects.is_published",
           "projects.created_at"
        );
        return self::build($postData, $columns);
    }

    public static function build(array $postData, array $columns){
        $dt = new self;
        $draw = isset($postData["draw"]) ? $postData["draw"] : 1;
		$totalRecords = $dt->dataTableCount();
		$totalDisplayRecords = $dt->dataTableRecord($postData,$columns, true);
		$aaData = $dt->dataTableRecord($postData,$columns, false);
		$result =  array(
			"draw"=> $draw,
			"iTotalRecords"=>$totalRecords,
			"iTotalDisplayRecords"=>$totalDisplayRecords,
			"aaData"=>$aaData
		);
        return $result;
    }

    public function dataTableCount(){
        return self::where("id","<>", 0)->count();
    }

    public function dataTableRecord(array $postData, array $columns, $count = false){

        $columnFilters = array(
            "projects.id",
            "projects.image",
            "category_projects.name",
            "projects.name",
            "projects.is_published",
            "projects.created_at"
        );

		$row = isset($postData["start"]) ? $postData["start"] : 1;
		$rowperpage = isset($postData["length"]) ? $postData["length"] : 10;

        $columnSortTarget = isset($postData["order"][0]["column"]) ? $postData["order"][0]["column"] : 0;
        $columnSortDesc = isset($postData["order"][0]["dir"]) ? $postData["order"][0]["dir"] : "desc";

		$columnIndex =  $columnFilters[$columnSortTarget];
		$columnSortOrder = $columnSortDesc;
		$searchValue = isset($postData["search"]["value"]) ? $postData["search"]["value"] : "";

        $mdl = new self;
        $data = $mdl->select($columns);
        $data = $data->join("category_projects", "category_projects.id", "projects.category_id");

        if(strlen($searchValue) > 0){
            $i = 1;
            foreach($columnFilters as $column){
                if($i == 1){
                    $data = $data->where($column, 'LIKE', '%' . $searchValue . '%');
                }else{
                    $data = $data->orWhere($column, 'LIKE', '%' . $searchValue . '%');
                }
                $i++;
            }
        }

        if($count){
            return $data->count();
        }else{
            return $data->skip($row)->take($rowperpage)->orderBy($columnIndex, $columnSortOrder)->get();
        }
    }

}
