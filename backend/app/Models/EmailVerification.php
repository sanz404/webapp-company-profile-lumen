<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Relations
use App\Models\User;

class EmailVerification extends Model  {

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
