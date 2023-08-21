<?php

namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
        "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education", "primary_occupation",
        "identifier", "identifier_type", "identifier_type_other", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
        "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop", "created_by", "other_insurance"
    ];

    /**  */
    public function getName(){
        return $this->surname . ' ' . $this->first_name . ' ' . $this->other_names;
    }

    /** @return County */
    public function county(){
        return County::where('code', $this->county_code)->first();
    }

    /** @return SubCounty*/
    public function subCounty(){
        return SubCounty::find($this->sub_county);
    }

    /** @return PatientReferral | null */
    public function lastReferral(){
        return PatientReferral::where('patient_id', $this->id)->orderBy('created_at', 'desc')->first();
    }

}
