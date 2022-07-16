<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\User;
use App\Models\ArticleComment;
use App\Models\CategoryArticle;

class Article extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'articles';

    protected $fillable = [
        "user_id",
        "image",
        "slug",
        "title",
        "content",
        "is_published"
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function Categories() {
        return $this->belongsToMany(CategoryArticle::class, "articles_categories", "article_id", "category_id");
    }

    public function getBySlug($slug){
        return self::where("sluf", $slug)->first();
    }

}
