<?php

use Infinitops\Referral\Models\Patient;

$patients = Patient::all();

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
    <ol class="breadcrumb mb-4 transparent">
        <li class="breadcrumb-item">
            <a href="index">Home</a>
        </li>
        <li class="breadcrumb-item active"> Patients </li>
    </ol>

</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>identifier</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Phone number</th>
                        <th>County</th>
                        <th>SubCounty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>identifier</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Phone number</th>
                        <th>County</th>
                        <th>SubCounty</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($patients as $patient) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $patient->getName(); ?></td>
                            <td><?php echo $patient->identifier; ?></td>
                            <td><?php echo $patient->dob ?></td>
                            <td><?php echo $patient->gender ?></td>
                            <td><?php echo $patient->phone_no ?></td>
                            <td><?php echo $patient->county()->name ?></td>
                            <td><?php echo $patient->subCounty()->name ?></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>