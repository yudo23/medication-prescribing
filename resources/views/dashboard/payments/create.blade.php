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
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
        <h5 class="page-title">Pembayaran</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-lg-6">
        <div class="card m-b-30">
            <div class="card-body">
                <form action="{{route('dashboard.payments.store')}}" method="post" autocomplete="off" enctype="multipart/form-data" id="frmStore">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Pemeriksaan Pasien<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <select class="form-control select2" name="record_id" required>
                                        <option value="">==Pilih Pemeriksaan Pasien==</option>
                                        @foreach ($records as $index => $row)
                                        <option value="{{$row->id}}">[{{$row->code}}] {{$row->name}} - {{$row->nik}} ({{number_format($row->total(),0,',','.')}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" name="date" placeholder="Tanggal Bayar" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nominal <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="amount" placeholder="Nominal" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Keterangan</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="note" placeholder="Keterangan"></textarea>
                                </div>
                            </div>
                            @if(Auth::user()->hasRole([
                                \App\Enums\RoleEnum::ADMINISTRATOR                            
                            ]))
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Apoteker<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <select class="form-control select2" name="apoteker_id" required>
                                        <option value="">==Pilih Apoteker==</option>
                                        @foreach ($apotekers as $index => $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{route('dashboard.payments.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm" disabled><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card m-b-30">
            <div class="card-body">
                <h5>Resep Dokter</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody class="tbody-prescriptions">
                            <tr>
                                <td colspan="10" class="text-center">Data obat tidak ditemukan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script>
    $(function() {

        $('button[type="submit"]').attr("disabled", false);

        $(document).on("change",'select[name="record_id"]',function(){
            let val = $(this).val();

            $('.tbody-prescriptions').html(`
                <tr>
                    <td colspan="10" class="text-center">Data obat tidak ditemukan</td>
                </tr>
            `);

            if(val){
                 $.ajax({
                    url: "{{ route('api.patient-records.show', '_id_') }}".replace("_id_", val),
                    method: "GET",
                    dataType: "JSON",
                    beforeSend: function() {
                        return openLoader();
                    },
                    success: function(resp) {
                        if (resp.success == false) {
                            return responseFailed(resp.message);
                        } else {
                            let html = '';

                            if(resp.data.prescriptions && resp.data.prescriptions.length >= 1){
                                $.each(resp.data.prescriptions,function(index,element){
                                    html += `
                                        <tr>
                                            <td class="text-center">${index+1}</td>
                                            <td>${element.medicine_name}</td>
                                            <td>${formatRupiah(element.price)}</td>
                                            <td>${element.qty}</td>
                                            <td>${element.note ?? ""}</td>
                                        </tr>
                                    `;
                                });

                                $('.tbody-prescriptions').html(html);
                            }
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 422) {
                            return responseFailed(request.responseJSON.message);
                        } else if (request.status == 419) {
                            return sessionTimeOut();
                        } else {
                            return responseInternalServerError();
                        }
                    },
                    complete: function() {
                        return closeLoader();
                    }
                })
            }
        })

        $(document).on('submit', '#frmStore', function(e) {
            e.preventDefault();
            if (confirm("Apakah anda yakin ingin menyimpan data ini ?")) {
                $.ajax({
                    url: $("#frmStore").attr("action"),
                    method: "POST",
                    data: new FormData($('#frmStore')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    beforeSend: function() {
                        return openLoader();
                    },
                    success: function(resp) {
                        if (resp.success == false) {
                            return responseFailed(resp.message);
                        } else {
                            return responseSuccess(resp.message, "{{route('dashboard.payments.index')}}");
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 422) {
                            return responseFailed(request.responseJSON.message);
                        } else if (request.status == 419) {
                            return sessionTimeOut();
                        } else {
                            return responseInternalServerError();
                        }
                    },
                    complete: function() {
                        return closeLoader();
                    }
                })
            }
        })
    })
</script>
@endsection