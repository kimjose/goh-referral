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
                    <input name="page" type="text" hidden value="analytics-users">
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
                $query = "select u.*, uc.name user_category, (select count(patient_id) from patient_referrals where created_by = u.id and created_at BETWEEN '{$start_date}' and '{$end_date}') 'referrals_done' from users u left join user_categories uc on u.category_id = uc.id";
                $users = DB::select($query);
            ?>
                <div class="table-responsive">
                    <table id="tableReferrals" class="table table-striped table-bordered">
                        <thead>
                            <th>User Name</th>
                            <th>User Category</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Referrals Done</th>
                            <th>Last login</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user->surname . ' ' . $user->first_name . ' ' . $user->middle_name ?></td>
                                    <td><?php echo $user->user_category ?></td>
                                    <td><?php echo $user->email ?></td>
                                    <td><?php echo $user->phone_number ?></td>
                                    <td><?php echo $user->referrals_done ?></td>
                                    <td><?php echo $user->last_login ?></td>
                                    <td><?php echo $user->status ?></td>
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