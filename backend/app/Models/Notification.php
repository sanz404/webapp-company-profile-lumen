<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\User;

class Notification extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'notifications';

    protected $fillable = [
        "user_id",
        "subject",
        "sort_content",
        "full_content",
        "readed_at"
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

}
