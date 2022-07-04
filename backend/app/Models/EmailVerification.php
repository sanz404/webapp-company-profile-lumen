<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// Relations
use App\Models\User;

class EmailVerification extends Model  {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'email_verifications';

    protected $fillable = [
        "user_id",
        "code",
        "token",
        "email_confirmed",
        "is_expired",
        "expired_at"
    ];

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

}
