@extends("dashboard.layouts.main")

@section("title","Profile")

@section("css")
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Profile</a></li>
                <li class="breadcrumb-item">Edit</li>
                <li class="breadcrumb-item active">{{$result->name}}</li>
            </ol>
        </div>
        <h5 class="page-title">Profile</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Data Profil</h4>
                <p class="card-title-desc">
                    Pastikan <code> Data Profil</code> di bawah sesuai dengan informasi pribadi Anda.
                </p>
                <form action="{{route('dashboard.profile.update')}}" method="POST" id="frmUpdate">
                    @csrf
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" value="{{ old('name', $result->name) }}" name="name">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" placeholder="Username" value="{{ old('username', $result->username) }}" name="username">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label">Email <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="email" class="form-control" placeholder="Email" value="{{ old('email', $result->email) }}" name="email">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-3 col-form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" placeholder="Nomor Telepon" value="{{ old('phone', $result->phone) }}" name="phone">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Ubah Profil
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Foto Profil</h4>
                <p class="card-title-desc">Pastikan <code> Foto Profil</code> di bawah sesuai dengan foto Anda.</p>
                <div class="text-center">
                    <img src="{{ $result->avatar ? asset($result->avatar) : 'https://avatars.dicebear.com/api/initials/' . Auth::user()->name . '.png?background=blue' }}" alt="user" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px;" required>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-primary btn-modal-foto">
                        Update Foto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ubah Password</h4>
                <p class="card-title-desc">
                    Pastikan <code> Data Password</code> di bawah sesuai dengan informasi pribadi Anda.
                </p>
                <form action="{{route('dashboard.profile.updatePassword')}}" method="POST" id="frmUpdatePassword">
                    @csrf
                    <div class="form-group row mb-3">
                        <label class="col-md-2 col-form-label">Password Lama <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="password" class="form-control" placeholder="Password Lama" value="{{ old('password_old', $result->password_old) }}" name="password_old">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-2 col-form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="password" class="form-control" placeholder="Password Baru" name="password">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-md-2 col-form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="password" class="form-control" placeholder="Konfirmasi Password Baru" name="password_confirmation">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateImage" tabindex="-1" aria-labelledby="modalUpdateFotoUpdate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateFotoUpdate">Upload Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="frmUpdateAvatar" action="{{ route('dashboard.profile.updateAvatar') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Foto <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="file" class="form-control" name="avatar" accept="image/*" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ubah Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section("script")
<script>
    $(function() {

        $('button[type="submit"]').attr("disabled", false);

        $(document).on("click", ".btn-modal-foto", function(e) {
            e.preventDefault();
            $('#modalUpdateImage').modal("show");
        })

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
                            responseFailed(resp.message);
                        } else {
                            responseSuccess(resp.message, "{{route('dashboard.profile.index')}}");
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 422) {
                            responseFailed(request.responseJSON.message);
                        } else {
                            responseInternalServerError();
                        }
                    },
                    complete: function() {
                        return closeLoader();
                    }
                })
            }
        })

        $(document).on('submit', '#frmUpdateAvatar', function(e) {
            e.preventDefault();
            if (confirm("Apakah anda yakin ingin menyimpan data ini ?")) {
                $.ajax({
                    url: $("#frmUpdateAvatar").attr("action"),
                    method: "POST",
                    data: new FormData($('#frmUpdateAvatar')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    beforeSend: function() {
                        return openLoader();
                    },
                    success: function(resp) {
                        if (resp.success == false) {
                            responseFailed(resp.message);
                        } else {
                            responseSuccess(resp.message, "{{route('dashboard.profile.index')}}");
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 422) {
                            responseFailed(request.responseJSON.message);
                        } else {
                            responseInternalServerError();
                        }
                    },
                    complete: function() {
                        return closeLoader();
                    }
                })
            }
        })

        $(document).on('submit', '#frmUpdatePassword', function(e) {
            e.preventDefault();
            if (confirm("Apakah anda yakin ingin menyimpan data ini ?")) {
                $.ajax({
                    url: $("#frmUpdatePassword").attr("action"),
                    method: "POST",
                    data: new FormData($('#frmUpdatePassword')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    beforeSend: function() {
                        return openLoader();
                    },
                    success: function(resp) {
                        if (resp.success == false) {
                            responseFailed(resp.message);
                        } else {
                            responseSuccess(resp.message, "{{route('dashboard.profile.index')}}");
                        }
                    },
                    error: function(request, status, error) {
                        if (request.status == 422) {
                            responseFailed(request.responseJSON.message);
                        } else {
                            responseInternalServerError();
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