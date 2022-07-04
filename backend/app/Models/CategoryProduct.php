<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Product;

class CategoryProduct extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'category_products';

    protected $fillable = [
        "name",
        "description"
    ];

    public function Product() {
        return $this->hasMany(Product::class);
    }


}
