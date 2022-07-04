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
        "images",
        "price",
        "description",
        "is_published"
    ];

    public function Category(){
        return $this->belongsTo(CategoryProduct::class, "category_id");
    }

}
