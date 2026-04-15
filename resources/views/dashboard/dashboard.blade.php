@extends("dashboard.layouts.main")

@section("title","Dashboard")

@section("css")
<!-- ChartJs Css -->
<link href="{{URL::to('/')}}/templates/dashboard/assets/plugins/chartjs/Chart.min.css" rel="stylesheet" type="text/css" />
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <h5 class="page-title">Dashboard</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-md-4">
        <div class="card mini-stat m-b-30">
            <div class="p-3 bg-primary text-white">
                <div class="mini-stat-icon">
                    <i class="fa fa-users float-right mb-0"></i>
                </div>
                <h6 class="text-uppercase mb-0">Pasien Minggu INi</h6>
            </div>
            <div class="card-body">
                <div class="mt-4 text-muted">
                    <h5 class="m-0">{{number_format($summary["total_patient_this_week"],0,',','.')}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stat m-b-30">
            <div class="p-3 bg-primary text-white">
                <div class="mini-stat-icon">
                    <i class="fa fa-users float-right mb-0"></i>
                </div>
                <h6 class="text-uppercase mb-0">Pasien Bulan Ini</h6>
            </div>
            <div class="card-body">
                <div class="mt-4 text-muted">
                    <h5 class="m-0">{{number_format($summary["total_patient_this_month"],0,',','.')}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mini-stat m-b-30">
            <div class="p-3 bg-primary text-white">
                <div class="mini-stat-icon">
                    <i class="fa fa-users float-right mb-0"></i>
                </div>
                <h6 class="text-uppercase mb-0">Pasien Tahun Ini</h6>
            </div>
            <div class="card-body">
                <div class="mt-4 text-muted">
                    <h5 class="m-0">{{number_format($summary["total_patient_this_year"],0,',','.')}}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
	    <div class="card m-b-30">
	        <div class="card-header bg-primary text-white">
	            <b>Grafik Transaksi {{{\Carbon\Carbon::now()->translatedFormat("Y")}}}</b>
	        </div>
	        <div class="card-body">
	            <canvas id="chart"></canvas>
	        </div>
	    </div>
	</div>
</div>
@endsection

@section("script")
<!-- ChartJs -->
<script src="{{URL::to('/')}}/templates/dashboard/assets/plugins/chartjs/Chart.min.js"></script>
<script>
    $(function() {

        var chart = new Chart(document.getElementById('chart').getContext('2d'), {
            type: 'line',
            data: {
                labels: JSON.parse('<?php echo json_encode($chart["labels"]); ?>'),
                datasets: [{
                    label: 'Grafik Transaksi {{{\Carbon\Carbon::now()->translatedFormat("Y")}}}',
                    data: JSON.parse('<?php echo json_encode($chart["values"]); ?>'),
                    borderColor: 'rgb(56, 193, 114)',
                    borderWidth: 1,
                    backgroundColor: 'rgba(56, 193, 114, 0.2)',
                }]
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            return t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        },
                    }]
                }
            }
        });

    })
</script>
@endsection