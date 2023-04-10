<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    
    protected $fillable = ['first_name', 'middle_name', 'surname', 'email', 'phone_number', 'password', 'category_id', 'last_login'];

}
