<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model{
    
    protected $fillable = ['name', 'description'];
    
    public $timestamps = false;

}
