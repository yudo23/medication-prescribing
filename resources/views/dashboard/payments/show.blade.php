@extends("dashboard.layouts.main")

@section("title","Pembayaran")

@section("css")
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pembayaran</a></li>
                <li class="breadcrumb-item">Show</li>
                <li class="breadcrumb-item active">{{$result->code}}</li>
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
                <h5 class="card-title mb-4">Informasi Pembayaran</h5>
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                # Pembayaran
                            </div>
                            <div class="col-md-8">
                                : {{ $result->code }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                # Pemeriksaan
                            </div>
                            <div class="col-md-8">
                                : <a href="{{route('dashboard.patient-records.show',$result->record_id)}}">{{$result->record->code ?? null}}</a>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nama Pasien
                            </div>
                            <div class="col-md-8">
                                : {{ $result->record->name ?? null }}
                            </div>
                        </div>
                         <div class="row mb-2">
                            <div class="col-md-3">
                                NIK
                            </div>
                            <div class="col-md-8">
                                : {{ $result->record->nik ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tanggal Bayar
                            </div>
                            <div class="col-md-8">
                                : {{\Carbon\Carbon::parse($result->date)->translatedFormat("d F Y")}}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nominal
                            </div>
                            <div class="col-md-8">
                                : {{ number_format($result->amount,0,',','.') }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Dokter
                            </div>
                            <div class="col-md-8">
                                : {{ $result->record->doctor->name ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Apoteker
                            </div>
                            <div class="col-md-8">
                                : {{ $result->apoteker->name ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Dibuat Oleh
                            </div>
                            <div class="col-md-8">
                                : {{ $result->author->name ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tanggal Dibuat
                            </div>
                            <div class="col-md-8">
                                : {{ \Carbon\Carbon::parse($result->created_at)->translatedFormat("d F Y H:i:s") }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tanggal Diperbarui
                            </div>
                            <div class="col-md-8">
                                : {{ \Carbon\Carbon::parse($result->updated_at)->translatedFormat("d F Y H:i:s") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{route('dashboard.payments.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                        @if($result->canPrintReceipt())
                        <a href="{{route('dashboard.payments.print-receipt',$result->id)}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-print"></i> Cetak Kwitansi</a>
                        @endif
                        @if($result->canDelete())
                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{$result->id}}"><i class="fa fa-trash"></i> Hapus</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="frmDelete" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="id" />
</form>
@endsection

@section("script")
<script>
    $(function(){
        $(document).on("click", ".btn-delete", function() {
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