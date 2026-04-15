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
                <li class="breadcrumb-item">Show</li>
                <li class="breadcrumb-item active">{{$result->id}}</li>
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
                <h5 class="card-title mb-4">Informasi Pemeriksaan Pasien</h5>
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Kode
                            </div>
                            <div class="col-md-8">
                                : {{ $result->code }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tanggal
                            </div>
                            <div class="col-md-8">
                                : {{ \Carbon\Carbon::parse($result->examined_date)->translatedFormat("d F Y") }}
                            </div>
                        </div>
                         <div class="row mb-2">
                            <div class="col-md-3">
                                Dokter
                            </div>
                            <div class="col-md-8">
                                : {{ $result->doctor->name ?? null }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Nama Pasien
                            </div>
                            <div class="col-md-8">
                                : {{ $result->name }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                NIK
                            </div>
                            <div class="col-md-8">
                                : {{ $result->nik }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Jenis Kelamin
                            </div>
                            <div class="col-md-8">
                                : {{ $result->gender }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tanggal Lahir
                            </div>
                            <div class="col-md-8">
                                : {{ \Carbon\Carbon::parse($result->date_of_birth)->translatedFormat("d F Y") }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Tinggi badan (cm)
                            </div>
                            <div class="col-md-8">
                                : {{ $result->height }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Berat badan (kg)
                            </div>
                            <div class="col-md-8">
                                : {{ $result->weight }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Systole
                            </div>
                            <div class="col-md-8">
                                : {{ $result->systole }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Diastole
                            </div>
                            <div class="col-md-8">
                                : {{ $result->diastole }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Heart Rate
                            </div>
                            <div class="col-md-8">
                                : {{ $result->heart_rate }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Respiration Rate
                            </div>
                            <div class="col-md-8">
                                : {{ $result->respiration_rate }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Suhu Tubuh
                            </div>
                            <div class="col-md-8">
                                : {{ $result->temperature }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Keterangan
                            </div>
                            <div class="col-md-8">
                                : {{ $result->note }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Berkas
                            </div>
                            <div class="col-md-8">
                                @if(!empty($result->attachment))
                                    : <a href="{{ asset($result->attachment) }}" target="_blank">
                                        Lihat Berkas
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Total
                            </div>
                            <div class="col-md-8">
                                : {{ number_format($result->total(),0,',','.') }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                Status
                            </div>
                            <div class="col-md-8">
                                : <span class="badge badge-{{$result->status()->class ?? null}}">{{$result->status()->msg ?? null}}</span>
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
                <div class="row my-3">
                    <div class="col-12">
                        <h5>Resep Obat</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                </thead>
                                <tbody>
                                    @foreach($result->prescriptions as $index => $row)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$row->medicine_name}}</td>
                                        <td>{{number_format($row->price,0,',','.')}}</td>
                                        <td>{{$row->qty}}</td>
                                        <td>{{$row->note}}</td>
                                        <td>{{number_format($row->total(),0,',','.')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{route('dashboard.patient-records.index')}}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                        @if($result->canUpdate())
                        <a href="{{route('dashboard.patient-records.edit',$result->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        @endif
                        @if($result->canPrintInvoice())
                        <a href="{{route('dashboard.patient-records.print-invoice',$result->id)}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-print"></i> Cetak Invoice</a>
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
                $("#frmDelete").attr("action", "{{ route('dashboard.patient-records.destroy', '_id_') }}".replace("_id_", id));
                $("#frmDelete").find('input[name="id"]').val(id);
                $("#frmDelete").submit();
            }
        })
    })
</script>
@endsection