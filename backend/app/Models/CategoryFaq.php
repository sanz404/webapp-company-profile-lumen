<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\Faq;

class CategoryFaq extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'category_faqs';

    protected $fillable = [
        "name",
        "description"
    ];

    public function Faq() {
        return $this->hasMany(Faq::class);
    }


}
