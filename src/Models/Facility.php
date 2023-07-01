<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model{

    protected $fillable = ['mfl_code', 'name', 'county_code'];

    /**
     * @return County
     */
    public function county(): County{
        return County::where('code', $this->county_code)->first();
    }

}
