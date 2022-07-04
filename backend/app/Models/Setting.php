<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'settings';

    protected $fillable = [
        "key_name",
        "key_value"
    ];

}
