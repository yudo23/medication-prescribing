@extends("dashboard.layouts.main")

@section("title","Rekening Perusahaan")

@section("css")
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Rekening Perusahaan</a></li>
                <li class="breadcrumb-item">Show</li>
                <li class="breadcrumb-item active">{{$result->id}}</li>
            </ol>
        </div>
        <h5 class="page-title">Rekening Perusahaan</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <h5 class="card-title mb-4">Informasi Rekening Perusahaan</h5>
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Perusahaan
                            </div>
                            <div class="col-md-8">
                                : {{ $result->company->name ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nama Bank
                            </div>
                            <div class="col-md-8">
                                : {{ $result->bank_name }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nama Pemilik Rekening
                            </div>
                            <div class="col-md-8">
                                : {{ $result->account_name }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nomor Rekening
                            </div>
                            <div class="col-md-8">
                                : {{ $result->account_number }}
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
                        <a href="{{route('dashboard.company-banks.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                        @if(Auth::user()->hasRole([
                            \App\Enums\RoleEnum::ADMINISTRATOR,
                            \App\Enums\RoleEnum::FINANCE,
                        ]))
                        <a href="{{route('dashboard.company-banks.edit',$result->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
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
                $("#frmDelete").attr("action", "{{ route('dashboard.company-banks.destroy', '_id_') }}".replace("_id_", id));
                $("#frmDelete").find('input[name="id"]').val(id);
                $("#frmDelete").submit();
            }
        })
    })
</script>
@endsection