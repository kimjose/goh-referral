<?php
namespace Infinitops\Referral\Models;;
require_once __DIR__ . "/../bootstrap.php";

use Illuminate\Database\Eloquent\Model;

class County extends Model {
    protected $table = 'counties';

    protected $fillable = ['name', 'code','capital', "latitude", "longitude"];
}