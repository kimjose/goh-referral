<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model{

    protected $fillable = ['access_token', 'refresh_token', 'user_id'];

}
