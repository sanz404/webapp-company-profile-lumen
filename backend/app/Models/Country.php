<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\User;

class Country extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'countries';

    protected $fillable = [
        "code",
        "name"
    ];

    public function User() {
        return $this->hasMany(User::class);
    }

}
