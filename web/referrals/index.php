<?php

use Infinitops\Referral\Models\PatientReferral;

$referrals = PatientReferral::all();
?>


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
    <ol class="breadcrumb mb-4 transparent">
        <li class="breadcrumb-item">
            <a href="index">Home</a>
        </li>
        <li class="breadcrumb-item active"> Referrals </li>
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
                        <th>Phone Number</th>
                        <th>Referred From</th>
                        <th>Referral Urgency</th>
                        <th>Date Referred</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>identifier</th>
                        <th>Phone Number</th>
                        <th>Referred From</th>
                        <th>Referral Urgency</th>
                        <th>Date Referred</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($referrals as $referral) : ?>
                        <tr>
                            <td></td>
                            <td><?php echo $referral->patient()->getName() ?></td>
                            <td><?php echo $referral->patient()->identifier ?></td>
                            <td><?php echo $referral->patient()->phone_no ?></td>
                            <td><?php echo $referral->referredFrom()->name ?></td>
                            <td><?php echo $referral->referral_urgency ?></td>
                            <td><?php echo $referral->created_at ?></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
