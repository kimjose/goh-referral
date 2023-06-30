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
$activeReferrals = PatientReferral::where('status', 'active')->orWhere('status', 'waiting')->get();
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
        <h3><?php echo sizeof($activeReferrals) ?></h3>

        <p>Active Referrals</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="index?page=referrals" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->

</div>
<!-- /top row boxes -->
<div class="row">
<div class="col-lg-6 mb-2">

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Patient Categorization by Age
            and Gender</h6>
        
    </div>
    <div class="card-body">
        <div class="chart-area">
            <canvas id="patientCategorization"></canvas>
        </div>
    </div>
</div>
</div>

</div>


<script>
  const patients = JSON.parse('<?php echo json_encode($patients) ?>')
  const patientCategorization = document.getElementById('patientCategorization')

  function drawPatientsCategorization() {
    let maleCat1 = 0
    let maleCat2 = 0
    let femaleCat1 = 0
    let femaleCat2 = 0

    patients.forEach(patient => {
      let age = calculateAge(new Date(patient.dob))
      if(age < 15){
        if(patient.gender == 'male') maleCat1++; else femaleCat1++
      } else{
        if(patient.gender == 'male') maleCat2++; else femaleCat2++
      }
    })
    
    const dataChartBarDoubleDatasetsExample = new Chart(patientCategorization, {
        type: 'bar',
        data: {
            labels: ["<15 years", "15+ years"],

            datasets: [
                {
                    label: 'Male',
                    data: [maleCat1, maleCat2],
                    backgroundColor: '#3895D3',
                    borderColor: '#3895D3',
                },
                {
                    label: 'Female',
                    data: [femaleCat1, femaleCat2],
                    backgroundColor: '#980147',
                    borderColor: '#980147',
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                xAxes: [
                    {
                        scaleLabel: {
                            display: true,
                            labelString: "Age Range",
                        },
                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }
                ],
                yAxes: [
                    {
                        scaleLabel: {
                            display: true,
                            labelString: "No. of Patients",
                        },
                        ticks: {
                            min: 0,
                            maxTicksLimit: 6,
                        },
                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }
                ]
            }
        },
    });

  }

  function calculateAge(dob) {
    let now = new Date();
    let age_diff = now.getTime() - dob.getTime();

    return Math.floor(age_diff / (1000 * 60 * 60 * 24 * 365.25));
}


  drawPatientsCategorization()
</script>