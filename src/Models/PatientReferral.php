<?php

namespace Infinitops\Referral\Models;

use Illuminate\Database\Eloquent\Model;

class PatientReferral extends Model{

    protected $fillable = ['patient_id', 'created_by', 'facility_id', 'department_id', 'diagnosis', 'presenting_problem', 'investigations', 'procedures_done',
'treatment_given', 'referral_reason', 'referral_urgency', 'status'];

}
