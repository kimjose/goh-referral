<?php


$educationLevels = [];
$occupations = [];
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
            </form>
        </div>
    </div>
</div>