<?php
namespace Infinitops\Referral\Models;;
require_once __DIR__ . "/../bootstrap.php";

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model {
    protected $table = 'sub_counties';

    protected $fillable = ['name', 'county_code' ];
}