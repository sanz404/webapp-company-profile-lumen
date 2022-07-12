<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
// Relations
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Country;
use App\Models\EmailVerification;
use App\Models\Notification;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject{

    use Authenticatable, Authorizable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    protected $fillable = [
        "country_id",
        "username",
        "email",
        "phone",
        "address1",
        "address2",
        "city",
        "zip_code",
        "password",
        "password_reset_token",
        "is_admin",
        "status"
    ];

    protected $hidden = [
        'password',
        'password_reset_token',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function Article() {
        return $this->hasMany(Article::class);
    }

    public function ArticleComment() {
        return $this->hasMany(ArticleComment::class);
    }

    public function EmailVerification() {
        return $this->hasMany(EmailVerification::class);
    }

    public function Notification() {
        return $this->hasMany(Notification::class);
    }

    public function Country(){
        return $this->belongsTo(Country::class, "country_id");
    }

    public static function getAll($postData, $user_id){
        $columns = array(
            "users.id",
            "users.username",
            "users.email",
            "users.phone",
            "countries.name as country_name",
            "users.status",
            "users.created_at",
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
        return self::where("id","!=",$user_id)->count();
    }

    public function dataTableRecord(array $postData, array $columns, $user_id, $count = false){

        $columnFilters = array(
            "users.id",
            "users.username",
            "users.email",
            "users.phone",
            "countries.name",
            "users.status",
            "users.created_at",
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
        $data = $data->where("users.id","!=",$user_id)->leftJoin("countries", "countries.id", "users.country_id");

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
