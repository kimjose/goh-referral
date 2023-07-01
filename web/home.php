<?php

use Infinitops\Referral\Models\User;
use Infinitops\Referral\Models\Patient;
use Illuminate\Database\Capsule\Manager as DB;
use Infinitops\Referral\Models\PatientReferral;

$base_url = $_ENV['APP_URL']  ?? "http://127.0.0.1/";
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

<script>
	const base_url = "<?php echo $base_url ?>"
</script>
<script src='../kenya-sponsored-map/js/mapbox.js'></script>
<script src="../kenya-sponsored-map/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="../kenya-sponsored-map/css/MarkerCluster.css" />
<link rel="stylesheet" type="text/css" href="../kenya-sponsored-map/css/MarkerCluster.Default.css" />
<script type='text/javascript' src='../kenya-sponsored-map/js/leaflet.markercluster.js'></script>
<link href='../kenya-sponsored-map/css/mapbox.css' rel='stylesheet' />


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
	<div class="col-lg-8 mb-4">
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Patients County Mapping</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<!-- <a class="dropdown-item" href="#" id="downloadmapcsv">Download csv</a> -->
					</div>
				</div>
			</div>
			<div class="card-body">
				<div id='map'></div>
			</div>
		</div>
	</div>
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
<script src="../kenya-sponsored-map/lib/jquery-csv-0.71.js"></script>
<script src="../kenya-sponsored-map/markers.js"></script>

<script>
	const patients = JSON.parse('<?php echo json_encode($patients) ?>')
	const patientCategorization = document.getElementById('patientCategorization')
	const rowHeaders = ['Location', 'County', 'Facilities', 'Patients'];
	let mapdata;



	$(function() {
		console.log("Method called...");

		fetch("get_map_data")
			.then(response => {
				return response.json();
			})
			.then(response => {
				console.log(response);
				if (response.code == 200) {
					JSONtoCSV(response.data)
				} else throw new Error(response.message);
			})
			.catch(err => {
				toastr.error(err.message)
				// alert(err.message);
			})

	})


	function JSONtoCSV(response) {
		var csvStr = rowHeaders.join(',') + '\n';

		console.log(response);

		response.forEach(element => {
			Location = element.Location;
			County = element.County;
			Facilities = element.Facilities;
			Patients = element.Patients;

			csvStr += '"' + Location + '",' + County + ',' + Facilities + ',' + Patients + '\n';
		});
		console.log(csvStr);
		mapdata = csvStr;
		populateMap(csvStr);

	}

	function downloadMapCSV(csvStr) {

		$.ajax({
			url: 'updatecsvfile',
			type: "POST",
			data: {
				file: csvStr
			},
			success: function(response) {
				console.log(response + 'csv file updated');
				$(document).ready(function() {
					var link = document.createElement("a");
					link.setAttribute("href", "./kenya-sponsored-map/data/rows.csv");
					link.setAttribute("download", "mapdata.csv");
					document.body.appendChild(link); // Required for FF

					link.click();
				});
			},
			error: function() {
				console.log('error updating csv file')
			}
		});
	}

	function drawPatientsCategorization() {
		let maleCat1 = 0
		let maleCat2 = 0
		let femaleCat1 = 0
		let femaleCat2 = 0

		patients.forEach(patient => {
			let age = calculateAge(new Date(patient.dob))
			if (age < 15) {
				if (patient.gender == 'male') maleCat1++;
				else femaleCat1++
			} else {
				if (patient.gender == 'male') maleCat2++;
				else femaleCat2++
			}
		})

		const dataChartBarDoubleDatasetsExample = new Chart(patientCategorization, {
			type: 'bar',
			data: {
				labels: ["<15 years", "15+ years"],

				datasets: [{
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
					xAxes: [{
						scaleLabel: {
							display: true,
							labelString: "Age Range",
						},
						gridLines: {
							drawOnChartArea: false,
						},
					}],
					yAxes: [{
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
					}]
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