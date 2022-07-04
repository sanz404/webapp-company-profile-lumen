<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Article;
use App\Models\User;

class ArticleComment extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'articles_comments';

    protected $fillable = [
        "article_id",
        "user_id",
        "description"
    ];

    public function Article(){
        return $this->belongsTo(Article::class, "article_id");
    }

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

}
