<?php

use Infinitops\Referral\Models\Patient;

$patients = Patient::all();

$activeBadge = "<span class=\"badge badge-primary rounded-pill\">Active</span>";
$referredBadge = "<span class=\"badge badge-warning rounded-pill\">Referred Elsewhere</span>";
$completedBadge = "<span class=\"badge badge-success rounded-pill\">Completed</span>";
$cancelledBadge = "<span class=\"badge badge-danger rounded-pill\">Cancelled</span>";

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
    <div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index?page=patients-edit"><i class="fa fa-plus"></i> Add New Patient</a>
			</div>
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
                        <th>Last Referral Status</th>
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
                        <th>Last Referral Status</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($patients as $patient) : 
                        $referral = $patient->lastReferral();
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $patient->getName(); ?></td>
                            <td><?php echo $patient->identifier; ?></td>
                            <td><?php echo $patient->dob ?></td>
                            <td><?php echo $patient->gender ?></td>
                            <td><?php echo $patient->phone_no ?></td>
                            <td><?php echo $patient->county()->name ?></td>
                            <td><?php echo $patient->subCounty()->name ?></td>
                            <td><?php echo $patient->lastReferral() ? ($referral->status == 'active' || $referral->status == 'waiting') ? $activeBadge : ($referral->status == 'completed' ? $completedBadge : ($referral->status == 'referred' ? $referredBadge : $cancelledBadge)) : '' ?></td>
                            <td>
                                <button class="btn btn-sm btn-flat btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action <span class="sr-only">Toggle Drropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="index?page=patients-edit&id=<?php echo $patient->id ?>">
                                        <span class="fa fa-edit text-primary"></span> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>