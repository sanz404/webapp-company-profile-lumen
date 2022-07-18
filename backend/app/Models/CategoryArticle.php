<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Article;

class CategoryArticle extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'category_articles';

    protected $fillable = [
        "name",
        "description"
    ];

    public function Articles() {
        return $this->belongsToMany(Article::class, "articles_categories",  "category_id", "article_id");
    }

}
