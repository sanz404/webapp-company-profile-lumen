<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'faqs';

    protected $fillable = [
        "question",
        "answer",
        "sort",
        "is_published"
    ];

}
