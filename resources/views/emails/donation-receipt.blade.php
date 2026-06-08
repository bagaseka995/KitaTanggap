<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Donasi — KitaTanggap</title>
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
            background: linear-gradient(135deg, #1F4E79, #2E75B6);
            color: #ffffff;
            padding: 30px 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 6px 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.85;
        }
        .success-badge {
            display: inline-block;
            background-color: #22C55E;
            color: #ffffff;
            padding: 6px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            margin: 16px auto 0;
            letter-spacing: 0.5px;
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
            border-left: 4px solid #22C55E;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .detail-row {
            margin-bottom: 12px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #6B7280;
            display: inline-block;
            width: 140px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .value {
            color: #333333;
            font-size: 14px;
        }
        .nominal-highlight {
            font-size: 28px;
            font-weight: 800;
            color: #1F4E79;
            text-align: center;
            margin: 24px 0;
            letter-spacing: -0.5px;
        }
        .bencana-card {
            background: linear-gradient(135deg, #EFF6FF, #F0F9FF);
            border: 1px solid #BFDBFE;
            border-radius: 10px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .bencana-card .bencana-name {
            font-weight: 700;
            font-size: 16px;
            color: #1F4E79;
            margin-bottom: 4px;
        }
        .bencana-card .bencana-loc {
            font-size: 13px;
            color: #6B7280;
        }
        .message-box {
            background-color: #FFFBEB;
            border: 1px solid #FDE68A;
            border-radius: 8px;
            padding: 14px 18px;
            margin: 20px 0;
            font-style: italic;
            color: #92400E;
            font-size: 14px;
        }
        .message-box .msg-label {
            font-style: normal;
            font-weight: 600;
            color: #B45309;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .thankyou {
            text-align: center;
            margin: 30px 0 10px 0;
            font-size: 15px;
            color: #4B5563;
        }
        .thankyou-heart {
            font-size: 24px;
            display: block;
            margin-bottom: 6px;
        }
        .btn {
            display: block;
            width: fit-content;
            margin: 24px auto 10px auto;
            padding: 12px 30px;
            background-color: #1F4E79;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(31, 78, 121, 0.25);
        }
        .divider {
            border: none;
            border-top: 1px dashed #E5E7EB;
            margin: 20px 0;
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
        {{-- Header --}}
        <div class="header">
            <h1>KitaTanggap</h1>
            <p>Bukti Donasi Resmi</p>
            <div class="success-badge">✓ PEMBAYARAN BERHASIL</div>
        </div>

        {{-- Content --}}
        <div class="content">
            <div class="greeting">Halo, {{ $nama_donatur }}!</div>

            <p>
                Terima kasih atas kebaikan hati Anda. Donasi Anda telah <strong>berhasil diproses</strong>
                dan akan disalurkan untuk membantu korban bencana. Berikut adalah bukti donasi Anda:
            </p>

            {{-- Nominal Highlight --}}
            <div class="nominal-highlight">{{ $nominal }}</div>

            {{-- Bencana Card --}}
            <div class="bencana-card">
                <div class="bencana-name">🚨 {{ $nama_bencana }}</div>
                <div class="bencana-loc">📍 {{ $lokasi_bencana }}</div>
            </div>

            {{-- Detail Transaksi --}}
            <div class="detail-card">
                <div class="detail-row">
                    <span class="label">Kode Transaksi</span>
                    <span class="value"><strong>{{ $kode_transaksi }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="label">Tanggal</span>
                    <span class="value">{{ $tanggal }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Metode Bayar</span>
                    <span class="value">{{ $metode }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Donatur</span>
                    <span class="value">{{ $nama_donatur }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Email</span>
                    <span class="value">{{ $email_donatur }}</span>
                </div>
            </div>

            {{-- Pesan dari Donatur (opsional) --}}
            @if($pesan)
            <div class="message-box">
                <div class="msg-label">💬 Pesan Anda</div>
                "{{ $pesan }}"
            </div>
            @endif

            <hr class="divider">

            {{-- Ucapan Terima Kasih --}}
            <div class="thankyou">
                <span class="thankyou-heart">💝</span>
                Setiap rupiah yang Anda donasikan sangat berarti<br>
                bagi mereka yang terdampak bencana.<br>
                <strong>Terima kasih telah menjadi bagian dari solusi!</strong>
            </div>

            <a href="{{ url('/peta') }}" class="btn">Lihat Bencana Lainnya</a>

            <p style="text-align: center; font-size: 12px; color: #9CA3AF; margin-top: 20px;">
                Simpan email ini sebagai bukti donasi resmi Anda.<br>
                Kode transaksi: <strong>{{ $kode_transaksi }}</strong>
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem KitaTanggap.<br>
                &copy; 2026 KitaTanggap Kelompok 11 RPL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
