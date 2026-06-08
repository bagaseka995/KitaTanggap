<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penugasan Misi Kemanusiaan Baru — KitaTanggap</title>
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
        .detail-card {
            background-color: #f8fafc;
            border-left: 4px solid #2E75B6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #555555;
            display: inline-block;
            width: 130px;
        }
        .value {
            color: #333333;
        }
        .btn {
            display: block;
            width: fit-content;
            margin: 30px auto 10px auto;
            padding: 12px 30px;
            background-color: #1F4E79;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(31, 78, 121, 0.25);
        }
        .btn:hover {
            background-color: #1a4267;
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
            <div class="greeting">Halo, {{ $nama }}!</div>
            <p>Anda telah terpilih dan ditugaskan dalam misi kemanusiaan baru oleh tim admin KitaTanggap. Terima kasih atas ketersediaan dan kepedulian Anda.</p>
            
            <p>Berikut rincian misi penugasan Anda:</p>
            
            <div class="detail-card">
                <div class="detail-row">
                    <span class="label">Bencana:</span>
                    <span class="value"><strong>{{ $nama_bencana }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="label">Lokasi:</span>
                    <span class="value">{{ $lokasi }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Tanggal Tugas:</span>
                    <span class="value">{{ $tanggal_tugas }}</span>
                </div>
                @if($catatan)
                <div class="detail-row" style="margin-top: 15px; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
                    <span class="label" style="vertical-align: top;">Catatan Admin:</span>
                    <span class="value" style="display: inline-block; max-width: 380px;"><em>"{{ $catatan }}"</em></span>
                </div>
                @endif
            </div>

            <p>Harap persiapkan diri Anda dan berkoordinasi dengan koordinator lapangan sesampainya di lokasi kejadian. Anda dapat memperbarui status penugasan dan melihat detail misi Anda melalui portal Relawan KitaTanggap.</p>
            
            <a href="{{ $link_riwayat }}" class="btn">Buka Riwayat Misi</a>
        </div>
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem KitaTanggap.<br>&copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
