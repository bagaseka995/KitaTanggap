<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Partisipasi Relawan — KitaTanggap</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1e8ed;
        }
        .header {
            background-color: #1F4E79;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1F4E79;
        }
        .badge {
            display: inline-block;
            background-color: #22C55E;
            color: #ffffff;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 4px;
            margin: 15px 0;
        }
        .details {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 14px;
        }
        .detail-row {
            margin-bottom: 8px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #555555;
            display: inline-block;
            width: 120px;
        }
        .btn {
            display: block;
            width: fit-content;
            margin: 25px auto 10px auto;
            padding: 12px 30px;
            background-color: #1F4E79;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(31, 78, 121, 0.25);
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #e1e8ed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KitaTanggap</h1>
        </div>
        <div class="content">
            <div class="greeting">Selamat, {{ $nama }}!</div>
            <p>Kami dari tim KitaTanggap mengucapkan terima kasih yang sebesar-besarnya atas kontribusi aktif dan dedikasi luar biasa Anda dalam penanganan bencana.</p>
            
            <p>Sebagai bentuk penghargaan resmi, sertifikat digital partisipasi Anda telah diterbitkan.</p>
            
            <div class="details">
                <div class="detail-row">
                    <span class="label">Bencana:</span>
                    <span class="value"><strong>{{ $nama_bencana }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="label">Kode Sertifikat:</span>
                    <span class="value" style="font-family: monospace;">{{ $kode_sertifikat }}</span>
                </div>
            </div>

            <p>Kami telah melampirkan sertifikat PDF resmi Anda pada email ini. Anda juga dapat memverifikasi keabsahan sertifikat ini kapan saja secara publik melalui tautan berikut:</p>
            
            <a href="{{ $link_verifikasi }}" class="btn">Verifikasi Sertifikat</a>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem KitaTanggap.<br>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
