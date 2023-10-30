<?php

use Illuminate\Database\Capsule\Manager as DB;

$submit = '';
if (isset($_GET['submit'])) {
    $submit = $_GET['submit'];
    extract($_GET);
}

?>


<div class="card">
    <div class="card-header">
        <form action="index" method="get">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <input name="page" type="text" hidden value="analytics-referrals">
                    <div class="form-group">
                        <label for="inputStartDate">Start Date</label>
                        <input type="date" name="start_date" id="inputStartDate" class="form-control" required value="<?php echo $submit ? $start_date : '' ?>">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="inputEndDate">End Date</label>
                        <input type="date" name="end_date" id="inputEndDate" class="form-control" required value="<?php echo $submit ? $end_date : '' ?>">
                    </div>
                </div>
            </div>
            <input class="btn-sm btn-block btn-wave col-md-4 btn-primary" type="submit" value="Get Report" name="submit">
        </form>
    </div>

    <div class="card-body">
        <div class="justify-content-center">
            <?php
            if ($submit) :
                $query = "select  pr.*, p.phone_no, concat(p.surname, ' ', p.first_name, ' ', p.other_names) patient_name, p.dob, DATEDIFF(CURDATE(), p.dob) div 365.25 as 'currage',
                d.name department, CONCAT(u.first_name, ' ', u.surname) as referred_by
                from patient_referrals pr left join patients p on p.id = pr.patient_id
                left join departments d on d.id = pr.department_id
                left join users u on u.id = pr.created_by where pr.created_at BETWEEN '{$start_date}' and '{$end_date}' ;";
                $referrals = DB::select($query);
            ?>
                <div class="table-responsive">
                    <table id="tableReferrals" class="table table-striped table-bordered">
                        <thead>
                            <th>Patient Name</th>
                            <th>DOB</th>
                            <th>Age</th>
                            <th>Department</th>
                            <th>Diagnosis</th>
                            <th>Presenting Problem</th>
                            <th>Investigations</th>
                            <th>Procedures Done</th>
                            <th>Treatment Given</th>
                            <th>Referral reason</th>
                            <th>Referral Urgency</th>
                            <th>Referred By</th>
                            <th>Referred At</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php foreach ($referrals as $referral) : ?>
                                <tr>
                                    <td><?php echo $referral->patient_name ?></td>
                                    <td><?php echo $referral->dob ?></td>
                                    <td><?php echo $referral->currage ?></td>
                                    <td><?php echo $referral->department ?></td>
                                    <td><?php echo $referral->diagnosis ?></td>
                                    <td><?php echo $referral->presenting_problem ?></td>
                                    <td><?php echo $referral->investigations ?></td>
                                    <td><?php echo $referral->procedures_done ?></td>
                                    <td><?php echo $referral->treatment_given ?></td>
                                    <td><?php echo $referral->referral_reason ?></td>
                                    <td><?php echo $referral->referral_urgency ?></td>
                                    <td><?php echo $referral->referred_by ?></td>
                                    <td><?php echo $referral->created_at ?></td>
                                    <td><?php echo $referral->status ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(function() {
                        $("#tableReferrals").DataTable({
                            "responsive": true,
                            "lengthChange": false,
                            "autoWidth": false,
                            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                        $('#example2').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                        });
                    });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>