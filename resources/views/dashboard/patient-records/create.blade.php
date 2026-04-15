@extends("dashboard.layouts.main")

@section("title","Pemeriksaan Pasien")

@section("css")
@endsection

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pemeriksaan Pasien</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
        <h5 class="page-title">Pemeriksaan Pasien</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-xl-12">
        <div class="card m-b-30">
            <div class="card-body">
                <form action="{{route('dashboard.patient-records.store')}}" method="post" autocomplete="off" enctype="multipart/form-data" id="frmStore">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Tanggal Periksa <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" name="examined_date" placeholder="Tanggal Periksa" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                                </div>
                            </div>
                            @if(Auth::user()->hasRole([
                                \App\Enums\RoleEnum::ADMINISTRATOR,
                            ]))
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Dokter<span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <select class="form-control select2" name="doctor_id" required>
                                        <option value="">==Pilih Dokter==</option>
                                        @foreach ($doctors as $index => $row)
                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Nama Pasien <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Pasien" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">NIK <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="nik" placeholder="NIK" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <select class="form-control" name="gender" required>
                                        <option value="">==Pilih Jenis Kelamin==</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="date" class="form-control" name="date_of_birth" placeholder="Tanggal Lahir" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Tinggi Badan (cm)</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="height" placeholder="Tinggi Badan (cm)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Berat Badan (kg)</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="weight" placeholder="Berat Badan (cm)">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Systole</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="systole" placeholder="Systole">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Diastole</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="diastole" placeholder="Diastole">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Heart Rate</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="heart_rate" placeholder="Heart Rate">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Respiration Rate</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="respiration_rate" placeholder="Respiration Rate">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Suhu Tubuh</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="temperature" placeholder="Suhu Tubuh">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Keterangan</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="note" placeholder="Keterangan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Berkas</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control" name="attachment" placeholder="Berkas">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h5 class="mb-2">Resep Obat</h5>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-primary btn-sm btn-add-medicine"><i class="fa fa-plus"> Tambah Obat</i></a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th style="width: 5%;">No</th>
                                        <th style="width: 50%;">Obat <span class="text-danger">*</span></th>
                                        <th style="width: 15%">Harga <span class="text-danger">*</span></th>
                                        <th style="width: 15%">Jumlah <span class="text-danger">*</span></th>
                                        <th style="width: 10%">Keterangan</th>
                                        <th style="width: 5%">Aksi</th>
                                    </thead>
                                    <tbody class="tbody-repeater">
                                        <tr class="repeater">
                                            <input type="hidden" class="form-control medicine_name" name="repeater[0][medicine_name]">
                                             <input type="hidden" class="form-control price" name="repeater[0][price]">
                                            <td class="number">1</td>
                                            <td>
                                                <select class="form-control select-medicine medicine_id" name="repeater[0][medicine_id]">
                                                    <option value="">==Pilih Obat==</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control price-readonly" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control qty" name="repeater[0][qty]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control note" name="repeater[0][note]">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{route('dashboard.patient-records.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
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

        initSelect2Medicine($('.select-medicine'));

        $(document).on('input change', 'input[name="examined_date"]', function() {
            let val = $(this).val();

            if (!val) {
                let firstRow = $('.tbody-repeater .repeater:first');
                let select = firstRow.find('.select-medicine');

                select.empty().append('<option value="">==Pilih Obat==</option>').trigger('change');

                firstRow.find('.price').val('');
                firstRow.find('.qty').val('');

                $('.tbody-repeater .repeater:not(:first)').remove();

                sortTableMedicine();
            }
        });

        $(document).on('change', '.select-medicine', function() {
            let medicine_id = $(this).val();
            let row = $(this).closest('tr');

            let text = $(this).find('option:selected').text();
            row.find('.medicine_name').val(text);

            getPrice(medicine_id, row);
        });

        $(document).on("click",".btn-add-medicine",function(e){
            e.preventDefault();

            let html = `
                <tr class="repeater">
                    <input type="hidden" class="form-control medicine_name" name="repeater[0][medicine_name]">
                    <input type="hidden" class="form-control price" name="repeater[0][price]">
                    <td class="number"></td>
                    <td>
                        <select class="form-control select-medicine medicine_id" name="repeater[0][medicine_id]"></select>
                    </td>
                    <td>
                        <input type="text" class="form-control price-readonly" name="repeater[0][price]" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control qty" name="repeater[0][qty]">
                    </td>
                    <td>
                        <input type="text" class="form-control note" name="repeater[0][note]">
                    </td>
                    <td>
                        <a class="btn btn-sm btn-remove-medicine text-danger"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            `;

            let row = $(html);
            $(".tbody-repeater").append(row);

            initSelect2Medicine(row.find('.select-medicine'));
            sortTableMedicine();
        });

        $(document).on("click",".btn-remove-medicine",function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            sortTableMedicine();
        });

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
                            return responseSuccess(resp.message, "{{route('dashboard.patient-records.index')}}");
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

        function sortTableMedicine(){
            $('.repeater').each(function(index,element){
                $('.repeater').eq(index).find('.number').html(index+1);
                $('.repeater').eq(index).find('.medicine_name').attr('name',`repeater[${index}][medicine_name]`);
                $('.repeater').eq(index).find('.medicine_id').attr('name',`repeater[${index}][medicine_id]`);
                $('.repeater').eq(index).find('.price').attr('name',`repeater[${index}][price]`);
                $('.repeater').eq(index).find('.qty').attr('name',`repeater[${index}][qty]`);
                $('.repeater').eq(index).find('.note').attr('name',`repeater[${index}][note]`);
            });
        }

        async function initSelect2Medicine(el){
            el.select2({
                placeholder: "==Pilih Obat==",
                width: '100%',
                minimumResultsForSearch: Infinity, 
                ajax: {
                    url: "{{route('api.medicines.index')}}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data.data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        };
                    }
                }
            });
        }

        function getPrice(medicine_id, row){
            let examined_date = $('input[name="examined_date"]').val();

            if(medicine_id && examined_date){
                $.ajax({
                    url: '{{route("api.medicines.price","_id_")}}'.replace("_id_", medicine_id),
                    method: "GET",
                    data : {
                        examined_date : examined_date,
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        return openLoader();
                    },
                    success: function(resp) {
                        if (resp.success == false) {
                            return responseFailed(resp.message);
                        } else {
                            row.find('.price').val(resp.data);
                            row.find('.price-readonly').val(formatRupiah(resp.data));
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
            }else{
                row.find('.price').val('');
            }
        }
    })
</script>
@endsection