@extends("dashboard.layouts.main")

@section("title","Log Pengguna")

@section("css")
<style>
    .action {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .action a {
        margin-bottom: 3px;
    }
</style>
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Log Pengguna</a></li>
                <li class="breadcrumb-item active">Log Pengguna</li>
            </ol>
        </div>
        <h5 class="page-title">Log Pengguna</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-12 action">
                        <a href="#" class="btn btn-warning btn-sm btn-filter"><i class="fa fa-filter"></i> Filter</a>
                        <a href="{{route('dashboard.log-users.index')}}" class="btn btn-secondary btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <th>No</th>
                                        <th>Keterangan</th>
                                        <th>Waktu</th>
                                        <th>Jenis</th>
                                        <th>Pengguna</th>
                                    </thead>
                                    <tbody>
                                        @forelse ($table as $index => $row)
                                        <tr>
                                            <td>{{$table->firstItem() + $index}}</td>
                                            <td>{{$row->note}}</td>
                                            <td>{{\Carbon\Carbon::parse($row->created_at)->translatedFormat("d F Y H:i:s")}}</td>
                                            <td>
                                                <span class="badge badge-{{$row->type()->class ?? null}}">{{$row->type()->msg ?? null}}</span>
                                            </td>
                                            <td>{{$row->author->name ?? null}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {!!$table->links()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("dashboard.log-users.modal.index")

@endsection

@section("script")
<script>
    $(function() {
        $(document).on("click", ".btn-filter", function(e) {
            e.preventDefault();

            $('#modalFilterLabel').html("Filter Pencarian");
            $("#frmFilter").attr("action", "{{ route('dashboard.log-users.index') }}");
            $("#modalFilter").modal("show");
        });
    })
</script>
@endsection