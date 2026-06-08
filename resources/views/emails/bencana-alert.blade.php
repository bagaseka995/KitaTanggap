<!DOCTYPE html>
<html>
<head>
    <title>Peringatan Dini Bencana</title>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 20px; }
        .container { background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 20px; }
        .status-awas { color: #EF4444; font-weight: bold; }
        .status-siaga { color: #F97316; font-weight: bold; }
        .status-waspada { color: #EAB308; font-weight: bold; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #2563EB; color: #ffffff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Peringatan Dini: {{ $bencana->nama_bencana }}</h2>
        </div>
        <p>Halo,</p>
        <p>Kami menginformasikan bahwa telah terjadi <strong>{{ $bencana->jenis_bencana }}</strong> di dekat wilayah Anda.</p>
        
        <ul>
            <li><strong>Lokasi:</strong> {{ $bencana->lokasi }}</li>
            <li><strong>Tanggal Kejadian:</strong> {{ $bencana->tanggal_kejadian ? $bencana->tanggal_kejadian->format('d M Y') : '-' }}</li>
            <li><strong>Status Siaga:</strong> <span class="status-{{ $bencana->status_siaga }}">{{ strtoupper($bencana->status_siaga) }}</span></li>
        </ul>

        <p><strong>Deskripsi Singkat:</strong><br>
        {{ Str::limit($bencana->deskripsi, 150) }}</p>

        <p>Harap tetap waspada dan ikuti arahan dari pihak berwenang setempat.</p>

        <center>
            <a href="{{ url('/donasi/' . $bencana->id) }}" class="btn">Lihat Detail Bencana & Donasi</a>
        </center>

        <p style="font-size: 12px; color: #6b7280; margin-top: 30px;">
            Anda menerima email ini karena wilayah domisili Anda terdaftar berada di dekat lokasi kejadian. 
            Jika Anda ingin berhenti menerima notifikasi, Anda dapat mengatur preferensi di profil Anda.
        </p>
    </div>
</body>
</html>
