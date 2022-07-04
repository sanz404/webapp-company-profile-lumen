<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'features';

    protected $fillable = [
        "icon",
        "title",
        "description",
        "is_published"
    ];

}
