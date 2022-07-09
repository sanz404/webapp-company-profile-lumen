<?php

namespace App\Utils;

class DataTable{

    public static function build(array $postData, array $columns, $model){
        $dt = new self;
        $draw = isset($postData["draw"]) ? $postData["draw"] : 1;
		$totalRecords = $dt->dataTableCount($model);
		$totalDisplayRecords = $dt->dataTableRecord($postData,$columns, $model, true);
		$aaData = $dt->dataTableRecord($postData,$columns, $model, false);
		$result =  array(
			"draw"=> $draw,
			"iTotalRecords"=>$totalRecords,
			"iTotalDisplayRecords"=>$totalDisplayRecords,
			"aaData"=>$aaData
		);
        return $result;
    }

    public function dataTableCount($model){
        $mdl = new $model;
        return $mdl->count();
    }

    public function dataTableRecord(array $postData, array $columns, $model, $count = false){

		$row = isset($postData["start"]) ? $postData["start"] : 1;
		$rowperpage = isset($postData["length"]) ? $postData["length"] : 10;

        $columnSortTarget = isset($postData["order"][0]["column"]) ? $postData["order"][0]["column"] : 0;
        $columnSortDesc = isset($postData["order"][0]["dir"]) ? $postData["order"][0]["dir"] : "desc";

		$columnIndex =  $columns[$columnSortTarget];
		$columnSortOrder = $columnSortDesc;
		$searchValue = isset($postData["search"]["value"]) ? $postData["search"]["value"] : "";

        $mdl = new $model;
        $data = $mdl->select($columns);

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
