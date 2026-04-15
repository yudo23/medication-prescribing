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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
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
    })
</script>
@endsection