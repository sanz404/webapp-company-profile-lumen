<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\CategoryProduct;

class Product extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'products';

    protected $fillable = [
        "category_id",
        "name",
        "image",
        "price",
        "description",
        "is_published"
    ];

    public function Category(){
        return $this->belongsTo(CategoryProduct::class, "category_id");
    }

    public static function getAllData($postData){
        $columns = array(
           "products.id",
           "category_products.name as category_name",
           "products.image",
           "products.name",
           "products.price",
           "products.is_published",
           "products.created_at"
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
            "products.id",
            "products.image",
            "category_products.name",
            "products.name",
            "products.price",
            "products.is_published",
            "products.created_at"
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
        $data = $data->join("category_products", "category_products.id", "products.category_id");

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
