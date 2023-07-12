<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model{
    
    protected $fillable = ['name', 'description', 'require_perm_id'];
    
    public $timestamps = false;

}
