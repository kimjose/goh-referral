<?php

use Infinitops\Referral\Models\County;
use Infinitops\Referral\Models\SubCounty;

$educationLevels = [];
$occupations = [];
$nationalities = [];
$relationships = [];
$mops = [];
$otherInsurances = [];
$counties = County::all();
$subCounties = SubCounty::all();
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
    <ol class="breadcrumb mb-4 transparent">
        <li class="breadcrumb-item">
            <a href="index">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="index?page=patients">Patients</a>
        </li>
        <li class="breadcrumb-item active"> Edit </li>
    </ol>

</div>
<div class="col-lg-12 m-2">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Patient Form</h4>
        </div>
        <div class="card-body">
            <form action="" id="formPatient">
                <h6>Basic Details</h6>
                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputIdentifier">Identifier</label>
                            <input class="form-control" type="text" name="identifier" id="inputIdentifier" required placeholder="Identifier">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectIdentifierType">Identifier Type</label>
                            <select name="identifier_type" id="selectIdentifierType" class="form-control">
                                <option value="" selected hidden>Select Identifier Type</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputSurname">Surname</label>
                            <input type="text" class="form-control" id="inputSurname" name="surname" required placeholder="Surname">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputFirstName">First name</label>
                            <input type="text" class="form-control" id="inputFirstName" name="first_name" required placeholder="First name">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputOtherNames">Other names</label>
                            <input name="other_names" type="text" class="form-control" id="inputOtherNames" placeholder="Other names">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputDob">Date of birth</label>
                            <input type="date" class="form-control" id="inputDob" required placeholder="DOB" name="dob">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectGender">Gender</label>
                            <select name="gender" id="selectGender" class="form-control" required>
                                <option value="" selected hidden>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectMaritalStatus">Marital Status</label>
                            <select name="marital_status" id="selectMaritalStatus" class="form-control" required>
                                <option value="" selected hidden>Select Marital Status</option>
                                <option value="Never Married">Never Married</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectEducation">Education Level</label>
                            <select name="education" id="selectEducation" class="form-control" required>
                                <option value="" selected hidden>Select education level</option>
                                <?php foreach ($educationLevels as $education) : ?>
                                    <option value="<?php echo $education ?>"><?php echo $education ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="select">Primary Occupation</label>
                            <select name="primary_occupation" id="selectEducation" class="form-control" required>
                                <option value="" selected hidden>Select primary occupation</option>
                                <?php foreach ($educationLevels as $education) : ?>
                                    <option value="<?php echo $education ?>"><?php echo $education ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputPhoneNo">Phone Number</label>
                            <input type="number" name="phone_no" id="inputPhoneNo" class="form-control" placeholder="Phone number" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputPhoneNoAlt">Alternate Phone Number</label>
                            <input type="number" name="phone_no_alt" id="inputPhoneNoAlt" class="form-control" placeholder="Alternate Phone number" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="email">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectNationality">Nationality</label>
                            <select name="nationality" id="selectNationality" class="form-control" required>
                                <option value="" selected hidden>Select Nationality</option>
                                <?php foreach ($nationalities as $nationality) : ?>
                                    <option value="<?php echo $nationality ?>"><?php echo $nationality ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectCounty">County</label>
                            <select name="county" id="selectCounty" class="form-control" required>
                                <option value="" selected hidden>Select County</option>
                                <?php foreach ($counties as $county) : ?>
                                    <option value="<?php echo $county->code ?>"><?php echo $county->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNearestHc">Nearest Health Centre</label>
                            <input type="text" name="nearest_health_centre" id="inputNearestHc" class="form-control" placeholder="Nearest Health Centre">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNokName">Next of kin</label>
                            <input type="text" name="nok_name" id="inputNokName" class="form-control" placeholder="Next of kin">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectNokRelationship">Relationship</label>
                            <select name="nok_relationship" id="selectNokRelationship" class="form-control" required>
                                <option value="" selected hidden>Select Relationship</option>
                                <?php foreach ($relationships as $relationship) : ?>
                                    <option value="<?php echo $relationship ?>"><?php echo $relationship ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNokPhoneNo">Next of kin phone number</label>
                            <input type="number" name="nok_phone_no" id="inputNokPhoneNo" class="form-control" placeholder="Next of kin phone number">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectHasNhif">Has NHIF</label>
                            <select name="has_nfif" id="selectHasNhif" class="form-control" required>
                                <option value="" selected hidden>Select Nationality</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNhifNumber">NHIF Number</label>
                            <input type="text" name="nhif_number" id="inputNhifNumber" class="form-control" placeholder="NHIF Number">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectPreferredMop">Preferred Mode of Payment</label>
                            <select name="preferred_mop" id="selectPreferredMop" class="form-control" required>
                                <option value="" selected hidden>Select</option>
                                <?php foreach ($mops as $mop) : ?>
                                    <option value="<?php echo $mop ?>"><?php echo $mop ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectOtherInsurance">Other Insurance</label>
                            <select name="other_insurance" id="selectOtherInsurance" class="form-control" required>
                                <option value="" selected hidden>Select</option>
                                <?php foreach ($otherInsurances as $otherInsurance) : ?>
                                    <option value="<?php echo $otherInsurance ?>"><?php echo $otherInsurance ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
                <hr>
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<script>
    const formPatient = document.getElementById('formPatient')
    formPatient.addEventListener('submit', e => {
        e.preventDefault();
        let formData = new FormData(formPatient);
        fetch('../patient/create', {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                "content-type": "application/x-www-form-urlencoded"
            }
        })
        .then(response => response.json())
        .then(response =>{
            if(response.code == 200){
                toastr.success(response.message);
                setTimeout(() => location.replace('index?page=patients'), 789)
            } else throw new Error(response.message);
        })
        .catch(error => {
            toastr.error(error.message);
        })
    })
</script>