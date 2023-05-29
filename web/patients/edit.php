<?php

use Infinitops\Referral\Models\County;
use Infinitops\Referral\Models\Patient;
use Infinitops\Referral\Models\SubCounty;

$k = '_7Op_';
$id = "";
if (isset($_GET['id']) && $_GET['id'] != null) {
    $id = $_GET['id'];
    $patient = Patient::find($id);
    if ($patient == null) die("Error processing request");
}

$subcounties = [];
$nationalities = [];
$handle = fopen(__DIR__ . "/../../public/assets/countries.json", 'r');
$data = fread($handle, filesize(__DIR__ . "/../../public/assets/countries.json"));
$countries = json_decode($data, true);
foreach ($countries as $country) {
    $nationalities[] = $country['nationality'];
}

$educationLevels = ["None", "Primary", "Secondary", "Tertiary"];
$occupations = ["Farmer", "Business", "Trading", "Manufacturing", "Teaching", "Student", "Healthcare Worker", "Security", "Transport", "Other"];

$relationships = ["Parent", "Sibling", "Spouse", "Child", "Relative", "Other"];
$mops = ["Cash", "Insurance", "Cooperate"];
$otherInsurances = ["Britam", "Directline", "UAP", "Heritage", "Madison", "CIC", "Old Mutual", "Jubilee"];
$counties = County::all();
$subCounties = SubCounty::all();
$subCountiesString = json_encode($subCounties);
$subCountiesString = str_replace("'", $k, $subCountiesString);
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
                            <input class="form-control" type="text" name="identifier" id="inputIdentifier" required placeholder="Identifier" value="<?php echo $id == '' ? '' : $patient->identifier ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectIdentifierType">Identifier Type</label>
                            <select name="identifier_type" id="selectIdentifierType" class="form-control">
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select Identifier Type</option>
                                <option value="national_id" <?php echo ($id != '' && $patient->identifier_type == 'national_id') ? 'selected' : '' ?>>National ID</option>
                                <option value="passport" <?php echo ($id != '' && $patient->identifier_type == 'passport') ? 'selected' : '' ?>>Passport</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputSurname">Surname</label>
                            <input type="text" class="form-control" id="inputSurname" name="surname" required placeholder="Surname" value="<?php echo $id == '' ? '' : $patient->surname ?>">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputFirstName">First name</label>
                            <input type="text" class="form-control" id="inputFirstName" name="first_name" required placeholder="First name" value="<?php echo $id == '' ? '' : $patient->first_name ?>">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputOtherNames">Other names</label>
                            <input name="other_names" type="text" class="form-control" id="inputOtherNames" placeholder="Other names" value="<?php echo $id == '' ? '' : $patient->other_names ?>">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputDob">Date of birth</label>
                            <input type="date" class="form-control" id="inputDob" required placeholder="DOB" name="dob" value="<?php echo $id == '' ? '' : $patient->dob ?>">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectGender">Gender</label>
                            <select name="gender" id="selectGender" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select Gender</option>
                                <option value="male" <?php echo ($id != '' && $patient->gender == 'male') ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?php echo ($id != '' && $patient->gender == 'female') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectMaritalStatus">Marital Status</label>
                            <select name="marital_status" id="selectMaritalStatus" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select Marital Status</option>
                                <option value="Never Married" <?php echo ($id != '' && $patient->marital_status == 'Never Married') ? 'selected' : '' ?>>Never Married</option>
                                <option value="Married" <?php echo ($id != '' && $patient->marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
                                <option value="Divorced" <?php echo ($id != '' && $patient->marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
                                <option value="Widowed" <?php echo ($id != '' && $patient->marital_status == 'Widowed') ? 'selected' : '' ?>>Widowed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectEducation">Education Level</label>
                            <select name="education" id="selectEducation" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select education level</option>
                                <?php foreach ($educationLevels as $education) : ?>
                                    <option value="<?php echo $education ?>" <?php echo ($id != '' && $patient->education == $education) ? 'selected' : '' ?>><?php echo $education ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="select">Primary Occupation</label>
                            <select name="primary_occupation" id="selectEducation" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select primary occupation</option>
                                <?php foreach ($occupations as $occupation) : ?>
                                    <option value="<?php echo $occupation ?>" <?php echo ($id != '' && $patient->primary_occupation == $occupation) ? 'selected' : '' ?>><?php echo $occupation ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputPhoneNo">Phone Number</label>
                            <input type="number" name="phone_no" id="inputPhoneNo" class="form-control" placeholder="Phone number" value="<?php echo $id == '' ? '' : $patient->phone_no ?>" required>
                        </div>
                    </div>

                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputPhoneNoAlt">Alternate Phone Number</label>
                            <input type="number" name="alt_phone_no" id="inputPhoneNoAlt" class="form-control" placeholder="Alternate Phone number" value="<?php echo $id == '' ? '' : $patient->alt_phone_no ?> ">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="email" value="<?php echo $id == '' ? '' : $patient->email ?>">
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectNationality">Nationality</label>
                            <select name="nationality" id="selectNationality" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select Nationality</option>
                                <?php foreach ($nationalities as $nationality) : ?>
                                    <option value="<?php echo $nationality ?>" <?php echo ($id != '' && $patient->nationality == $nationality) ? 'selected' : '' ?>><?php echo $nationality ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectCounty">County</label>
                            <select name="county_code" id="selectCounty" class="form-control" required onchange="countySelectChanged()">
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select County</option>
                                <?php foreach ($counties as $county) :
                                    if ($id != '' && $county->code == $patient->county_code) :
                                        $subcounties = $county->subCounties();
                                ?>
                                        <option value="<?php echo $county->code ?>" selected><?php echo $county->name ?></option>
                                    <?php endif; ?>
                                    <option value="<?php echo $county->code ?>"><?php echo $county->name ?></option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectSubCounty">Sub County</label>
                            <select name="sub_county" id="selectSubCounty" class="form-control" required>
                                <option value="" <?php echo $id == '' ? 'selected' : '' ?> hidden>Select Sub County</option>
                                <?php foreach ($subcounties as $subcounty) : ?>
                                    <option value="<?php echo $subcounty->id ?>" <?php echo ($id != '' && $patient->sub_county == $subcounty->id) ? 'selected' : '' ?>><?php echo $subcounty->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNearestHc">Nearest Health Centre</label>
                            <input type="text" name="nearest_health_centre" id="inputNearestHc" class="form-control" placeholder="Nearest Health Centre" value="<?php echo $id == '' ? '' : $patient->nearest_health_centre ?> ">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNokName">Next of kin</label>
                            <input type="text" name="nok_name" id="inputNokName" class="form-control" placeholder="Next of kin" value="<?php echo $id == '' ? '' : $patient->nok_name ?> ">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectNokRelationship">Relationship</label>
                            <select name="nok_relationship" id="selectNokRelationship" class="form-control" required>
                                <option value="" selected hidden>Select Relationship</option>
                                <?php foreach ($relationships as $relationship) : ?>
                                    <option value="<?php echo $relationship ?>" <?php echo ($id != '' && $patient->nok_relationship == $relationship) ? 'selected' : '' ?>><?php echo $relationship ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNokPhoneNo">Next of kin phone number</label>
                            <input type="text" name="nok_phone_no" id="inputNokPhoneNo" class="form-control" placeholder="Next of kin phone number" value="<?php echo $id == '' ? '' : $patient->nok_phone_no ?> ">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectHasNhif">Has NHIF</label>
                            <select name="has_nhif" id="selectHasNhif" class="form-control" required>
                                <option value="" selected hidden>Has NHIF</option>
                                <option value="1" <?php echo ($id != '' && $patient->has_nhif == 1) ? 'selected' : '' ?>>Yes</option>
                                <option value="0" <?php echo ($id != '' && $patient->has_nhif == 0) ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="inputNhifNumber">NHIF Number</label>
                            <input type="text" name="nhif_number" id="inputNhifNumber" class="form-control" placeholder="NHIF Number" value="<?php echo $id == '' ? '' : $patient->nhif_number ?> ">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectPreferredMop">Preferred Mode of Payment</label>
                            <select name="preferred_mop" id="selectPreferredMop" class="form-control" required>
                                <option value="" selected hidden>Select</option>
                                <?php foreach ($mops as $mop) : ?>
                                    <option value="<?php echo $mop ?>" <?php echo ($id != '' && $patient->preferred_mop == $mop) ? 'selected' : '' ?>><?php echo $mop ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-8">
                        <div class="form-group">
                            <label for="selectOtherInsurance">Other Insurance</label>
                            <select name="other_insurance" id="selectOtherInsurance" class="form-control">
                                <option value="" selected hidden>Select</option>
                                <?php foreach ($otherInsurances as $otherInsurance) : ?>
                                    <option value="<?php echo $otherInsurance ?>" <?php echo ($id != '' && $patient->other_insurance == $otherInsurance) ? 'selected' : '' ?>><?php echo $otherInsurance ?></option>
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
    const k = '<?php echo $k ?>'
    const id = '<?php echo $id ?>'
    const formPatient = document.getElementById('formPatient')
    const selectCounty = document.getElementById('selectCounty')
    const selectSubCounty = document.getElementById('selectSubCounty')
    const subCounties = JSON.parse('<?php echo $subCountiesString ?>')
    formPatient.addEventListener('submit', e => {
        e.preventDefault();
        let formData = new FormData(formPatient);
        let patient = {}
        for (let [key, value] of formData.entries()) {
            patient[key] = value;
        }
        console.log(formData);
        fetch(id == '' ? 'patient/create' : `patient/update/${id}`, {
                method: 'POST',
                body: JSON.stringify(patient),
                headers: {
                    "content-type": "application/x-www-form-urlencoded"
                }
            })
            .then(response => response.json())
            .then(response => {
                if (response.code == 200) {
                    toastr.success(response.message);
                    setTimeout(() => location.replace('index?page=patients'), 789)
                } else throw new Error(response.message);
            })
            .catch(error => {
                toastr.error(error.message);
            })
    })

    const countySelectChanged = () => {
        let selected = $(selectCounty).val();
        let subs = subCounties.filter(({
            county_code
        }) => {
            return county_code == selected
        })
        selectSubCounty.innerHTML = '<option value=""  hidden>Select Sub County</option>'
        subs.forEach(sub => {
            let option = document.createElement('option')
            let name = sub.name
            name = name.replace(k, "'")
            option.value = sub.id
            option.innerText = name
            selectSubCounty.appendChild(option)
        })
    }
</script>