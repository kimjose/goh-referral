<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model{
    
    protected $fillable = ['name', 'description', 'permissions', 'deleted'];

}
