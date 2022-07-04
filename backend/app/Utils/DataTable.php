<?php

namespace App\Utils;

class DataTable{

    public static function build(array $postData, array $columns, $model, $limit = 10, $offset = 0){

        $limit      = isset($postData["limit"]) ? $postData["limit"] : 10;
        $offset     = isset($postData["offset"]) ? $postData["offset"] : 0;
        $order_by   = isset($postData["order_by"]) ? $postData["order_by"] : "id";
        $order_type = isset($postData["order_type"]) ? $postData["order_type"] : "desc";
        $search     = isset($postData["search"]) ? $postData["search"] : null;

        $mdl = new $model;
        $data = $mdl->select($columns);

        if(strlen($search) > 0){
            $i = 1;
            foreach($columns as $column){
                if($i == 1){
                    $data = $data->where($column, 'LIKE', '%' . $search . '%');
                }else{
                    $data = $data->orWhere($column, 'LIKE', '%' . $search . '%');
                }
                $i++;
            }
        }

        $data = $data->skip($offset*$limit)
            ->take($limit)
            ->orderBy($order_by, $order_type)
            ->get();

        return $data;

    }

}
