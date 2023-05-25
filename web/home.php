<?php

use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\Patient;
use Illuminate\Database\Capsule\Manager as DB;
use Infinitops\Referral\Models\PatientReferral;

$thisMonth = date('y-m-01');

$startDate = date_create(date('y-m-d'));
$endDate = date('Y-m-d');
date_sub($startDate, date_interval_create_from_date_string("60 days"));
$startDate = date_format($startDate, 'Y-m-d');

$users = User::all();
$patients = Patient::all();
$referrals = PatientReferral::all();

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between">
  <ol class="breadcrumb mb-4 transparent">

    <li class="breadcrumb-item active"> Home </li>
  </ol>

</div>

<!-- top row boxes -->
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo sizeof($users); ?></h3>

        <p>Users</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="index?page=users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo sizeof($patients) ?></h3>

        <p>Patients</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="index?page=patients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-secondary">
      <div class="inner">
        <h3><?php echo sizeof($referrals) ?></h3>

        <p>Referrals</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="index?page=referrals" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo '' ?></h3>

        <p>Active Referrals</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="index?page=visits" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

</div>
<!-- /top row boxes -->

<h4>Visits Overview</h4>
<div class="row">
  <div class="col-lg-8 col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fa fa-chart-line mr-1"></i>
          Visits Over Time
        </h3>
      </div>
      <div class="card-body">
        <canvas class="chart" id="graphVisitsOverTime" style="min-height: 280px; height: 280px; max-height: 280px; max-width: 100%;"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-header bg-primary">
            <h6 class="card-title"> Facilities with most visits</h6>
          </div>
          <div class="card-body p-2">
            <ul class=" p-0" style="list-style:none; overflow-y:auto; overflow-x:hidden; min-height: 260px; height: 260px; max-height: 260px;">
              <?php for ($i = 0; $i < 5; $i++) :
                $facility = $facilities[$i]; ?>
                <li class="mt-1">
                  <div class="row" style="">
                    <div class="col-8">
                      <p><?php echo $facility->name ?></p>
                    </div>
                    <div class="col-4">
                      <h4 class="text-center text-info"><?php echo $facility->visits ?? 0 ?></h4>
                    </div>
                  </div>
                </li>
              <?php endfor; ?>
            </ul>
            <a href="index?page=facilities" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card">
          <div class="card-header bg-warning">
            <h6 class="card-title"> Facilities with least visits</h6>
          </div>
          <div class="card-body">
            <ul class=" p-0" style="list-style:none; overflow-y:auto; overflow-x:hidden; min-height: 260px; height: 260px; max-height: 260px;">
              <?php for ($i = 1; $i <= 5; $i++) :
                $facility = $facilities[sizeof($facilities) - $i]; ?>
                <li class="mt-1">
                  <div class="row" style="">
                    <div class="col-8">
                      <p><?php echo $facility->name ?></p>
                    </div>
                    <div class="col-4">
                      <h4 class="text-center text-info"><?php echo $facility->visits ?? 0 ?></h4>
                    </div>
                  </div>
                </li>
              <?php endfor; ?>
            </ul>
            <a href="index?page=facilities" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Response Category Analysis</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
        <canvas id="canvasResponse" height="300" style="height: 300px;"></canvas>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer p-0">
    </div>
    <!-- /.footer -->
  </div>

  <!-- Custom tabs (Charts with tabs)-->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <i class="fas fa-chart-pie mr-1"></i>
        Visits
      </h3>
      <div class="card-tools">
        <ul class="nav nav-pills ml-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
          </li>
        </ul>
      </div>
    </div><!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content p-0">
        <!-- Morris chart - Sales -->
        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
          <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
        </div>
        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
          <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
        </div>
      </div>
    </div><!-- /.card-body -->
  </div>

</div>


<script>
  
</script>