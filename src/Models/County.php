<?php
namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model {
    protected $table = 'counties';

    protected $fillable = ['name', 'code','capital', "latitude", "longitude"];

    public function subCounties(){
        return SubCounty::where('county_code', $this->code)->get();
    }
    
}