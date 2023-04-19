<?php

namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    protected $fillable = [
        "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education_level", "primary_occupation",
        "identifier", "identifier_type", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
        "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop", "created_by"
    ];
}
