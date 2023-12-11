<?php

namespace Infinitops\Referral\Controllers;

use Infinitops\Referral\Controllers\Utils\Utility;
use Infinitops\Referral\Models\PatientReferral;

class ReferralsController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->verifyTokenAuth();
    }

    public function getReferrals(){
        response(SUCCESS_RESPONSE_CODE, "Referrals", PatientReferral::all());
    }

    public function createReferral($data){
        try {
            $attributes = ['patient_id', 'facility_id', 'department_id', 'diagnosis', 'presenting_problem', 'investigations', 'procedures_done',
            'treatment_given', 'referral_reason', 'referral_urgency', 'status'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $activeReferrals = PatientReferral::where(function($query){
                $query->where('status', 'waiting')->orWhere('status', 'pending procedure');
            })->where('patient_id', $data['patient_id'])->get();
            if(sizeof($activeReferrals) > 0) throw new \Exception("Patient has active referrals.");
            $data['created_by'] = $this->user->id;
            $referral = PatientReferral::create($data);
            response(SUCCESS_RESPONSE_CODE, "Referral created successfully.", $referral);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

    public function updateReferral($id, $data){
        try {
            $attributes = ['patient_id', 'facility_id', 'department_id', 'diagnosis', 'presenting_problem', 'investigations', 'procedures_done',
            'treatment_given', 'referral_reason', 'referral_urgency', 'status'];
            $missing = Utility::checkMissingAttributes($data, $attributes);
            throw_if(sizeof($missing) > 0, new \Exception("Missing parameters passed : " . json_encode($missing)));
            $referral = PatientReferral::find($id);
            if($referral == null) throw new \Exception("Referral not found");
            $referral->update($data);
            response(SUCCESS_RESPONSE_CODE, "Referral updated successfully", $referral);
        } catch (\Throwable $th) {
            Utility::logError($th->getCode(), $th->getMessage());
            response(PRECONDITION_FAILED_ERROR_CODE, $th->getMessage());
        }
    }

}
