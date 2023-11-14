<?php

namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model{

    protected $fillable = ["name", "deleted", "deleted_by"];

}
