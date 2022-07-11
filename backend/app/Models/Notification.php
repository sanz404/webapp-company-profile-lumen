<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\User;

class Notification extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'notifications';

    protected $fillable = [
        "user_id",
        "subject",
        "sort_content",
        "full_content",
        "readed_at"
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

    public static function getAll($postData, $user_id){
        $columns = array(
            "id",
            "created_at",
            "subject",
            "sort_content",
            "readed_at",
        );
        return self::build($postData, $columns, $user_id);
    }

    public static function build(array $postData, array $columns, $user_id){
        $dt = new self;
        $draw = isset($postData["draw"]) ? $postData["draw"] : 1;
		$totalRecords = $dt->dataTableCount($user_id);
		$totalDisplayRecords = $dt->dataTableRecord($postData,$columns, $user_id, true);
		$aaData = $dt->dataTableRecord($postData,$columns, $user_id, false);
		$result =  array(
			"draw"=> $draw,
			"iTotalRecords"=>$totalRecords,
			"iTotalDisplayRecords"=>$totalDisplayRecords,
			"aaData"=>$aaData
		);
        return $result;
    }

    public function dataTableCount($user_id){
        return self::where("user_id", $user_id)->count();
    }

    public function dataTableRecord(array $postData, array $columns, $user_id, $count = false){

		$row = isset($postData["start"]) ? $postData["start"] : 1;
		$rowperpage = isset($postData["length"]) ? $postData["length"] : 10;

        $columnSortTarget = isset($postData["order"][0]["column"]) ? $postData["order"][0]["column"] : 0;
        $columnSortDesc = isset($postData["order"][0]["dir"]) ? $postData["order"][0]["dir"] : "desc";

		$columnIndex =  $columns[$columnSortTarget];
		$columnSortOrder = $columnSortDesc;
		$searchValue = isset($postData["search"]["value"]) ? $postData["search"]["value"] : "";

        $mdl = new self;
        $data = $mdl->select($columns);
        $data = $data->where("user_id", $user_id);

        if(strlen($searchValue) > 0){
            $i = 1;
            foreach($columns as $column){
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
