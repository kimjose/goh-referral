<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model {
    
    protected $fillable = ['user_id', 'pin', 'is_used', 'expires_at'];

}
