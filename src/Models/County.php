<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model {
    protected $table = 'counties';

    protected $fillable = ['name', 'code','capital', "latitude", "longitude"];
}