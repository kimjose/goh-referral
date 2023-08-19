<?php

use Infinitops\Referral\Models\PatientReferral;

$id = '';
if (isset($_GET['id'])) $id = $_GET['id'];
/**@var PatientReferral */
$referral = PatientReferral::find($id);
if ($referral == null) die("Couldn't proceed");
$facility = $referral->referredFrom();

if (!hasPermission(PERM_USER_MANAGEMENT, $currUser)) :
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
        <li class="breadcrumb-item">
            <a href="index?page=referrals">Referrals</a>
        </li>
        <li class="breadcrumb-item active"> View </li>
    </ol>

</div>

<div class="card shadow mb-4">
    <div class="card-header">
        <h4>Referral Details</h4>
    </div>
    <div class="card-body">
        <div id="divReferralDetails">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="row">
                        <div class="col-4">
                            <h6>Patient Name</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div class=""><?php echo $referral->patient()->getName() ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="row">
                        <div class="col-4">
                            <h6>Date Referred</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->created_at ?></div>
                        </div>
                    </div>


                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Facility referred from</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $facility->name . ' - ( ' . $facility->mfl_code . ')' ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Department</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->referredFromDepartment()->name ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Diagnosis</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->diagnosis ?></div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Presenting Problem</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->presenting_problem ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Investigations</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->investigations ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Procedures Done</h6>
                        </div>
                        <div class="col-8 referral_detail">
                            <div><?php echo $referral->procedures_done ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Treatment Given</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->treatment_given ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Referral Reason</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->referral_reason ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Referral Urgency</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->referral_urgency ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h6>Referral Status</h6>
                        </div>
                        <div class="col-auto referral_detail">
                            <div><?php echo $referral->status ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr>
        <?php if ($referral->status != 'completed' && $referral->status != 'cancelled' && $referral->status != 'referred') : ?>

            <div class="col-auto">
                <h6>Referral Status</h6>
                <select name="status" id="selectReferralStatus">
                    <option value="waiting" <?php echo $referral->status == 'waiting' || $referral->status == 'active' ? 'selected' : '' ?>>Waiting</option>
                    <option value="pending procedure" <?php echo $referral->status == 'pending procedure' ? 'selected' : '' ?>>Pending procedure</option>
                    <option value="referred" <?php echo $referral->status == 'referred elsewhere' ? 'selected' : '' ?>>Referred Elsewhere</option>
                    <option value="completed" <?php echo $referral->status == 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?php echo $referral->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>

                <button id="btnUpdateStatus" class="btn btn-primary">Update Status</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    #divReferralDetails {
        background-color: #FFFDD0;
        padding: 10px;
        border-radius: 8px;
    }

    .referral_detail {
        border-bottom: #000019 1px solid;
        color: #009765;
    }
</style>

<script>
    const id = '<?php echo $id ?>'
    const btnUpdateStatus = document.getElementById('btnUpdateStatus')
    const selectReferralStatus = document.getElementById('selectReferralStatus')
    btnUpdateStatus.addEventListener('click', function(event) {
        let status = $(selectReferralStatus).val();
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
    })
</script>