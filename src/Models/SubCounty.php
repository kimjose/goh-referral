<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model {
    protected $table = 'sub_counties';

    protected $fillable = ['name', 'county_code' ];
}