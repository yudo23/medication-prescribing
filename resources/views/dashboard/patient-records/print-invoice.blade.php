<!DOCTYPE html>
<html>
<head>
    <title>Resep Dokter #{{$result->code}}</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        .header { text-align: left; margin-bottom: 20px; }
        .line { border-top: 1px solid #000; margin: 10px 0; }
    </style>
</head>
<body>

<div class="header">
    <h3 style="text-align: center;">RESEP DOKTER</h3>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="50%" valign="top">
            <p><b># Tagihan:</b> {{ $result->code ?? null }}</p>
            <p><b>Tanggal Periksa:</b>
                {{ \Carbon\Carbon::parse($result->examined_date)->translatedFormat("d F Y") }}
            </p>
            <p><b>Nama Pasien:</b> {{ $result->name ?? null }}</p>
            <p><b>Dokter:</b> {{ $result->doctor->name ?? null }}</p>
        </td>
    </tr>
</table>

<br>

<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: left;">Nama Obat</th>
            <th style="text-align: right;">Harga</th>
            <th style="text-align: right;">Jumlah</th>
            <th style="text-align: left;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result->prescriptions as $index => $row)
        <tr>
            <td style="text-align: center;">{{$index+1}}</td>
            <td>{{ $row->medicine_name }}</td>
            <td style="text-align: right;">{{ number_format($row->price,0,',','.') }}</td>
            <td style="text-align: right;">{{ $row->qty }}</td>
            <td>{{ $row->note }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right;" colspan="2"><b>Total</b></td>
            <td style="text-align: right;"><b>{{number_format($row->record->total(),0,',','.')}}</b></td>
            <td style="text-align: right;"><b>{{$row->record->prescriptions->sum("qty")}}</b></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<br><br>

<table width="100%" style="margin-top:40px;">
    <tr>
        <td width="50%"></td>

        <td width="50%" align="center">
            Dokter <br><br><br><br>
            ({{ $result->doctor->name ?? '-' }})
        </td>
    </tr>
</table>

</body>
</html>