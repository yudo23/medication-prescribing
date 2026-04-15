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
                <li class="breadcrumb-item">Edit</li>
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
                <form action="{{route('dashboard.company-banks.update',$result->id)}}" method="post" autocomplete="off" enctype="multipart/form-data" id="frmUpdate">
                    @method("PUT")
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Perusahaan<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <select class="form-control select2" name="company_id" required>
                                        <option value="">==Pilih Perusahaan==</option>
                                        @foreach ($companies as $index => $row)
                                        <option value="{{$row->id}}" {{$row->id == $result->company_id ? "selected" : ""}}>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nama Bank <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="bank_name" placeholder="Nama Bank" value="{{$result->bank_name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="account_name" placeholder="Nama Pemilik Rekening" value="{{$result->account_name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="account_number" placeholder="Nomor Rekening" value="{{$result->account_number}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{route('dashboard.company-banks.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary btn-sm" disabled><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script>
    $(function() {

        $('button[type="submit"]').attr("disabled", false);

        $(document).on('submit', '#frmUpdate', function(e) {
            e.preventDefault();
            if (confirm("Apakah anda yakin ingin menyimpan data ini ?")) {
                $.ajax({
                    url: $("#frmUpdate").attr("action"),
                    method: "POST",
                    data: new FormData($('#frmUpdate')[0]),
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
                            return responseSuccess(resp.message, "{{route('dashboard.company-banks.index')}}");
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