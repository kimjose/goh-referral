<?php

namespace Infinitops\Referral\Controllers;

use Infinitops\Referral\Models\Patient;
use Infinitops\Referral\Controllers\Utils\Utility;

class PatientsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->verifyTokenAuth();
    }
    
    public function getPatients()
    {
        response(SUCCESS_RESPONSE_CODE, "Patients", Patient::all());
    }

    public function createPatient($data)
    {
        try {
            $attributes = [
                "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education_level", "primary_occupation",
                "identifier", "identifier_type", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
                "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop"
            ];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $data['created_by'] = $this->user->id;
            $patient = Patient::create($data);
            response(SUCCESS_RESPONSE_CODE, "Patient created successfully.", $patient);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function updatePatient($id, $data)
    {
        try {
            $attributes = [
                "surname", "first_name", "other_names", "gender", "dob", "marital_status", "education_level", "primary_occupation",
                "identifier", "identifier_type", "phone_no", "alt_phone_no", "email", "nationality", "county_code", "sub_county", "nearest_health_centre",
                "nok_name", "nok_relationship", "nok_phone_no", "has_nhif", "nhif_number", "preferred_mop"
            ];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $patient = Patient::find($id);
            if ($patient == null) throw new \Exception("Patient not found.");
            $patient->update($data);
            response(SUCCESS_RESPONSE_CODE, "Patient created successfully.", $patient);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }
}
