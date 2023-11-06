<?php

use Infinitops\Referral\Models\PatientReferral;

$referrals = PatientReferral::all();

$activeBadge = "<span class=\"badge badge-primary rounded-pill\">Active</span>";
$referredBadge = "<span class=\"badge badge-warning rounded-pill\">Referred Elsewhere</span>";
$pendingBadge = "<span class=\"badge badge-warning rounded-pill\">Pending Procedure</span>";
$completedBadge = "<span class=\"badge badge-success rounded-pill\">Completed</span>";
$cancelledBadge = "<span class=\"badge badge-danger rounded-pill\">Cancelled</span>";

if (!hasPermission(PERM_MANAGE_REFERRALS, $currUser)) :
?>
    <script>
        window.location.replace("index")
    </script>
<?php endif; ?>

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
            <table id="tableReferrals" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>identifier</th>
                        <th>Phone Number</th>
                        <th>Referred From</th>
                        <th>Referral Urgency</th>
                        <th>Date Referred</th>
                        <th>Status</th>
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
                        <th>Status</th>
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
                            <td><?php
                                echo ($referral->status == 'active' || $referral->status == 'waiting') ? $activeBadge : ($referral->status == 'completed' ? $completedBadge : ($referral->status == 'referred' ? $referredBadge : ($referral->status == 'pending procedure' ? $pendingBadge : $cancelledBadge)))
                                ?></td>
                            <td>
                                <button class="btn btn-sm btn-flat btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action <span class="sr-only">Toggle Drropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <?php if ($referral->status == 'active' || $referral->status == 'waiting') : ?>
                                        <div class="dropdown-item" onclick="updateStatus('completed', <?php echo $referral->id ?>)">
                                            <span class="fa fa-check text-success"></span> Completed
                                        </div>
                                        <div class="dropdown-item" onclick="updateStatus('cancelled', <?php echo $referral->id ?>)">
                                            <span class="fa fa-times text-danger"></span> Cancelled
                                        </div>
                                    <?php endif; ?>
                                    <a href="index?page=referrals-view&id=<?php echo $referral->id ?>" class="dropdown-item"> <span class="fa fa-eye text-primary"></span> View </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const tableReferrals = document.getElementById('tableReferrals');
    $(document).ready(function() {
        tableReferrals.dataTable();
    });

    function updateStatus(status, id) {
        customConfirm('Update Status', "Are you sure you want to update the status of this referral?", () => {
            fetch('referral/update-status', {
                    method: 'POST',
                    body: JSON.stringify({
                        status: status,
                        id: id
                    }),
                    headers: {
                        "content-type": "application/x-www-form-urlencoded"
                    }
                })
                .then(response => {
                    return response.json()
                })
                .then(response => {
                    if (response.code == 200) {
                        toastr.success(response.message);
                        setTimeout(() => location.reload(), 789)
                    } else throw new Error(response.message);
                })
                .catch(error => {
                    toastr.error(error.message);
                })
        }, () => {})
    }
</script>