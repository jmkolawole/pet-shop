<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JwtToken extends Model
{
    use HasFactory;

    protected $table = 'jwt_tokens';
    protected $fillable = ['user_id','unique_id','token_title','expires_at'];
}
