@extends("dashboard.layouts.main")

@section("title","Pembayaran")

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
                <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </div>
        <h5 class="page-title">Pembayaran</h5>
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
                         @if(Auth::user()->hasRole([
                            \App\Enums\RoleEnum::ADMINISTRATOR,
                            \App\Enums\RoleEnum::APOTEKER,
                        ]))
                        <a href="{{route('dashboard.payments.create')}}" class="btn btn-primary btn-sm btn-add"><i class="fa fa-plus"></i> Tambah</a>
                        @endif
                        <a href="#" class="btn btn-warning btn-sm btn-filter"><i class="fa fa-filter"></i> Filter</a>
                        <a href="{{route('dashboard.payments.index')}}" class="btn btn-secondary btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <div class="table">
                                <table class="table">
                                    <thead>
                                        <th>Aksi</th>
                                        <th>No</th>
                                        <th># Pembayaran</th>
                                        <th># Pemeriksaan</th>
                                        <th>Nama Pasien</th>
                                        <th>NIK</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Nominal</th>
                                        <th>Dokter</th>
                                        <th>Apoteker</th>
                                    </thead>
                                    <tbody>
                                        @forelse ($table as $index => $row)
                                        <tr>
                                            <td>
                                                <div class="dropdown mo-mb-2">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-bars"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{route('dashboard.payments.show',$row->id)}}" class="dropdown-item"><i class="fa fa-eye"></i> Show</a>
                                                        @if($row->canDelete())
                                                        <a href="#" class="dropdown-item btn-delete" data-id="{{$row->id}}"><i class="fa fa-trash"></i> Hapus</a>
                                                        @endif
                                                        @if($row->canPrintReceipt())
                                                        <a href="{{route('dashboard.payments.print-receipt',$row->id)}}"  class="dropdown-item"><i class="fa fa-print"></i> Cetak Kwitansi</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$table->firstItem() + $index}}</td>
                                            <td>{{$row->code}}</td>
                                            <td>
                                                <a href="{{route('dashboard.patient-records.show',$row->record_id)}}">{{$row->record->code ?? null}}</a>
                                            </td>
                                            <td>{{$row->record->name ?? null}}</td>
                                            <td>{{$row->record->nik ?? null}}</td>
                                            <td>{{\Carbon\Carbon::parse($row->date)->translatedFormat("d F Y")}}</td>
                                            <td>{{number_format($row->amount)}}</td>
                                            <td>{{$row->record->doctor->name ?? null}}</td>
                                            <td>{{$row->apoteker->name ?? null}}</td>
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

@include("dashboard.payments.modal.index")

<form id="frmDelete" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="id" />
</form>

@endsection

@section("script")
<script>
    $(function() {
        $(document).on("click", ".btn-filter", function(e) {
            e.preventDefault();

            $('#modalFilterLabel').html("Filter Pencarian");
            $("#frmFilter").attr("action", "{{ route('dashboard.payments.index') }}");
            $("#modalFilter").modal("show");
        });

        $(document).on("click", ".btn-delete", function(e) {
            e.preventDefault();

            let id = $(this).data("id");
            if (confirm("Apakah anda yakin ingin menghapus data ini ?")) {
                $("#frmDelete").attr("action", "{{ route('dashboard.payments.destroy', '_id_') }}".replace("_id_", id));
                $("#frmDelete").find('input[name="id"]').val(id);
                $("#frmDelete").submit();
            }
        })
    })
</script>
@endsection