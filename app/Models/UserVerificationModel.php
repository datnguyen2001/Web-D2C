<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVerificationModel extends Model
{
    use HasFactory;
    protected $table = 'user_verifications';
    protected $fillable = [
        'email',
        'verification_code'
    ];
}
