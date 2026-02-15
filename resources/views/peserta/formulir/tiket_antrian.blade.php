<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Antrian Atribut</title>
    <style>
        * { margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            padding: 15px;
        }
        .container {
            border: 2px solid #000;
            padding: 15px;
            text-align: center;
        }
        .logo {
            margin-bottom: 5px;
        }
        .logo img {
            width: 40px;
        }
        .institution {
            font-size: 8px;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 5px;
        }
        .title {
            font-size: 12px;
            font-weight: bold;
            padding: 5px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin: 8px 0;
            letter-spacing: 1px;
        }
        .info-table {
            width: 100%;
            text-align: left;
            font-size: 10px;
            margin: 10px 0;
        }
        .info-table td {
            padding: 3px 5px;
        }
        .info-table .lbl {
            font-weight: bold;
            width: 50px;
        }
        .queue-box {
            border: 2px solid #000;
            background: #eee;
            padding: 10px;
            margin: 10px 0;
        }
        .queue-label {
            font-size: 9px;
            font-weight: bold;
        }
        .queue-number {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 3px;
        }
        .qr-box {
            margin: 10px 0;
        }
        .qr-box img {
            width: 70px;
            height: 70px;
        }
        .qr-text {
            font-size: 8px;
            color: #666;
            margin-top: 3px;
        }
        .notes {
            font-size: 8px;
            text-align: left;
            border-top: 1px dashed #000;
            padding-top: 8px;
            margin-top: 8px;
            color: #444;
        }
        .footer {
            font-size: 7px;
            color: #888;
            margin-top: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="{{ public_path('img/logo_uii.webp') }}">
    </div>
    <div class="institution">
        PANITIA PENDAFTARAN MAHASISWA/I WISUDA<br>
        UNIVERSITAS ISLAM INTERNASIONAL<br>
        DARULLUGHAH WADDA'WAH
    </div>
    <div class="title">TIKET ANTRIAN ATRIBUT</div>
    
    <table class="info-table">
        <tr><td class="lbl">Nama</td><td>: {{ $peserta->nama }}</td></tr>
        <tr><td class="lbl">NIM</td><td>: {{ $peserta->nim ?? '-' }}</td></tr>
        <tr><td class="lbl">Prodi</td><td>: {{ $peserta->getProdi->alias ?? '-' }}</td></tr>
    </table>
    
    <div class="queue-box">
        <div class="queue-label">NOMOR ANTRIAN</div>
        <div class="queue-number">{{ $antrian->nomor_antrian }}</div>
    </div>
    
    <div class="qr-box">
        @php
            $qrCode = base64_encode(QrCode::format('png')->size(70)->generate(strval($peserta->id)));
        @endphp
        <img src="data:image/png;base64,{{ $qrCode }}">
        <div class="qr-text">Scan QR untuk verifikasi</div>
    </div>
    
    <div class="notes">
        * Tunjukkan tiket ini saat pengambilan atribut<br>
        * Tiket berlaku untuk 1x pengambilan
    </div>
    
    <div class="footer">
        Dicetak: {{ now()->format('d/m/Y H:i') }} | ID: {{ $peserta->id }}
    </div>
</div>
</body>
</html>
