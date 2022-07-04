<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'teams';

    protected $fillable = [
        "image",
        "name",
        "position",
        "description",
        "is_published"
    ];

}
