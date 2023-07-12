<?php

namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class PatientReferral extends Model
{

    protected $fillable = [
        'patient_id', 'created_by', 'facility_id', 'department_id', 'diagnosis', 'presenting_problem', 'investigations', 'procedures_done',
        'treatment_given', 'referral_reason', 'referral_urgency', 'status'
    ];

    /** @return Patient */
    public function patient(){
        return Patient::find($this->patient_id);
    }

    /** @return User */
    public function referredBy(){
        return User::find($this->created_by);
    }

    /** @return Facility */
    public function referredFrom(){
        return Facility::find($this->facility_id);
    }

    /** @return Department */
    public function referredFromDepartment(){
        return Department::find($this->department_id);
    }
}
