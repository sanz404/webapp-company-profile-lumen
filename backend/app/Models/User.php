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



}
