<?php

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
    </div>
    </div>
</div>