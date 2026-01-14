<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpustakaan - {{ $title ?? 'Report' }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .report-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-title h2 {
            margin: 0;
            text-decoration: underline;
            font-size: 20px;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .signature {
            text-align: center;
            width: 250px;
        }
        .signature p {
            margin-bottom: 80px;
        }
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-family: sans-serif;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <a href="javascript:window.print()" class="no-print">Cetak ke PDF / Printer</a>

    <div class="header">
        <h1>PERPUSTAKAAN DIGITAL {{ strtoupper(config('app.name')) }}</h1>
        <p>Jl. Pendidikan No. 123, Kota Digital, Indonesia</p>
        <p>Email: library@example.com | Telp: (021) 12345678</p>
    </div>

    <div class="report-title">
        <h2>{{ strtoupper($title ?? 'LAPORAN PERPUSTAKAAN') }}</h2>
        <p>Periode: {{ $periode ?? 'Semua Waktu' }}</p>
    </div>

    @yield('content')

    <div class="footer">
        <div class="signature">
            <p>Dicetak pada: {{ date('d F Y') }}<br>Administrator Perpustakaan,</p>
            <strong>( .................................... )</strong>
            <br>NIP. ...........................
        </div>
    </div>
</body>
</html>
