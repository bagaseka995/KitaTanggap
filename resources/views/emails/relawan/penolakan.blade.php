<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pendaftaran Relawan</title>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.1); }
        .header { background: #1F4E79; padding: 32px 40px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 22px; }
        .header p { color: rgba(255,255,255,.75); margin: 6px 0 0; font-size: 14px; }
        .body { padding: 36px 40px; color: #374151; line-height: 1.7; }
        .alert { background: #FEF2F2; border-left: 4px solid #EF4444; border-radius: 6px; padding: 16px 20px; margin: 20px 0; }
        .alert h3 { color: #DC2626; margin: 0 0 6px; font-size: 15px; }
        .alert p { margin: 0; color: #6B7280; font-size: 14px; }
        .steps { background: #EFF6FF; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
        .steps h3 { color: #1F4E79; margin: 0 0 12px; font-size: 15px; }
        .steps ol { margin: 0; padding-left: 20px; color: #374151; font-size: 14px; }
        .steps li { margin-bottom: 6px; }
        .btn { display: inline-block; background: #1F4E79; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 14px; margin: 16px 0; }
        .footer { background: #F9FAFB; padding: 20px 40px; text-align: center; font-size: 12px; color: #9CA3AF; border-top: 1px solid #E5E7EB; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🌐 KitaTanggap</h1>
        <p>Sistem Informasi Penanganan Bencana Indonesia</p>
    </div>
    <div class="body">
        <p>Yth. <strong>{{ $nama }}</strong>,</p>
        <p>Terima kasih telah mendaftar sebagai relawan di platform KitaTanggap. Kami menghargai antusias dan semangat Anda untuk berkontribusi dalam penanganan bencana.</p>

        <div class="alert">
            <h3>⚠️ Pendaftaran Tidak Dapat Disetujui</h3>
            <p>Setelah melalui proses peninjauan, tim verifikasi kami belum dapat menyetujui pendaftaran relawan Anda saat ini.</p>
        </div>

        <p>Beberapa alasan umum penolakan pendaftaran:</p>
        <ul style="color:#6B7280;font-size:14px;">
            <li>Informasi keahlian kurang spesifik atau relevan</li>
            <li>Keterangan pengalaman belum lengkap</li>
            <li>Data profil perlu dilengkapi</li>
        </ul>

        <div class="steps">
            <h3>💡 Langkah Selanjutnya</h3>
            <ol>
                <li>Perbarui profil relawan Anda dengan informasi yang lebih lengkap</li>
                <li>Cantumkan keahlian spesifik yang relevan (medis, SAR, logistik, dll.)</li>
                <li>Jelaskan pengalaman Anda di bidang kebencanaan secara detail</li>
                <li>Daftarkan ulang setelah memperbarui profil</li>
            </ol>
        </div>

        <p style="text-align:center;">
            <a href="{{ config('app.url') }}/relawan/profil" class="btn">Perbarui Profil Saya</a>
        </p>

        <p style="color:#6B7280;font-size:13px;">
            Jika Anda memiliki pertanyaan, silakan hubungi tim KitaTanggap melalui email
            <a href="mailto:admin@kitatanggap.id" style="color:#1F4E79;">admin@kitatanggap.id</a>.
        </p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} KitaTanggap — Universitas Jenderal Soedirman</p>
        <p>Email ini dikirim otomatis, mohon tidak membalas langsung.</p>
    </div>
</div>
</body>
</html>
