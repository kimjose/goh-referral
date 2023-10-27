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
            if($submit):
                $query = "select  pr.*, p.phone_no, concat(p.surname, ' ', p.first_name, ' ', p.other_names), p.dob, DATEDIFF(CURDATE(), p.dob) div 365.25 as 'currage',
                d.name department, CONCAT(u.first_name, ' ', u.surname) as referred_by
                from patient_referrals pr left join patients p on p.id = pr.patient_id
                left join departments d on d.id = pr.department_id
                left join users u on u.id = pr.created_by where pr.created_at BETWEEN '{$start_date}' and '{$end_date}' ;";
                $referrals = DB::select($query);
            ?>
            <div class="table-responsive">
                <table>
                    
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>