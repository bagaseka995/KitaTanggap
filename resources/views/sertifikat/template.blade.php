<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Relawan - {{ $penugasan->relawan->user->nama_lengkap }}</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            -webkit-print-color-adjust: exact;
        }
        /* Certificate Outer Frame */
        .cert-container {
            width: 297mm;
            height: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            background-color: #ffffff;
            position: relative;
        }
        /* Double Border Frame */
        .cert-border {
            width: 257mm;
            height: 170mm;
            border: 6px double #1F4E79;
            padding: 10px;
            box-sizing: border-box;
            position: relative;
            background-image: radial-gradient(circle, #fcfdfe 0%, #f4f8fb 100%);
        }
        .cert-inner-border {
            width: 100%;
            height: 100%;
            border: 1px solid #2E75B6;
            padding: 20px;
            box-sizing: border-box;
            text-align: center;
        }
        /* Corner ornaments */
        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border-color: #1F4E79;
            border-style: solid;
        }
        .corner-tl { top: 15px; left: 15px; border-width: 3px 0 0 3px; }
        .corner-tr { top: 15px; right: 15px; border-width: 3px 3px 0 0; }
        .corner-bl { bottom: 15px; left: 15px; border-width: 0 0 3px 3px; }
        .corner-br { bottom: 15px; right: 15px; border-width: 0 3px 3px 0; }

        /* Header styling */
        .cert-header {
            margin-top: 10px;
            margin-bottom: 25px;
        }
        .brand-name {
            font-size: 28px;
            font-weight: 800;
            color: #1F4E79;
            letter-spacing: 2px;
            margin: 0;
        }
        .brand-tagline {
            font-size: 10px;
            color: #2E75B6;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 5px 0 0 0;
            font-weight: bold;
        }

        /* Certificate Title */
        .cert-title {
            font-size: 26px;
            font-weight: bold;
            color: #1F4E79;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .cert-subtitle {
            font-size: 11px;
            color: #555555;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 25px;
        }

        /* Recipient Info */
        .given-to {
            font-size: 14px;
            font-style: italic;
            color: #555555;
            margin-bottom: 10px;
        }
        .recipient-name {
            font-size: 32px;
            font-weight: bold;
            color: #1d1d1d;
            border-bottom: 2px solid #2E75B6;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 20px;
            min-width: 400px;
        }

        /* Description / Misi */
        .cert-desc {
            font-size: 14px;
            color: #444444;
            line-height: 1.6;
            max-width: 700px;
            margin: 0 auto 30px auto;
        }
        .disaster-name {
            font-weight: bold;
            color: #1F4E79;
            font-size: 16px;
        }

        /* Signatures / Metadata Table */
        .cert-footer-table {
            width: 100%;
            margin-top: 20px;
            position: absolute;
            bottom: 30px;
            left: 0;
            padding: 0 40px;
            box-sizing: border-box;
        }
        .sign-title {
            font-size: 12px;
            color: #555555;
            margin-bottom: 45px;
        }
        .sign-name {
            font-size: 14px;
            font-weight: bold;
            color: #1F4E79;
            border-top: 1px solid #cccccc;
            padding-top: 5px;
            display: inline-block;
            width: 180px;
        }
        
        /* Monospace Codes & Verification Links */
        .metadata-section {
            font-size: 10px;
            color: #777777;
            line-height: 1.5;
            text-align: left;
        }
        .cert-code {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            color: #333333;
            font-size: 11px;
        }
        .verification-url {
            color: #2E75B6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="cert-container">
        <div class="cert-border">
            {{-- Decorative corners --}}
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>

            <div class="cert-inner-border">
                {{-- Header --}}
                <div class="cert-header">
                    <h1 class="brand-name">KitaTanggap</h1>
                    <p class="brand-tagline">Tanggap, Peduli, Transparan</p>
                </div>

                {{-- Title --}}
                <div class="cert-title">SERTIFIKAT PENGHARGAAN</div>
                <div class="cert-subtitle">Misi Kemanusiaan Relawan</div>

                {{-- Given To --}}
                <div class="given-to">Sertifikat ini diberikan dengan hormat kepada:</div>
                <div class="recipient-name">{{ $penugasan->relawan->user->nama_lengkap }}</div>

                {{-- Description --}}
                <div class="cert-desc">
                    Atas dedikasi, kepedulian, dan partisipasi aktifnya sebagai relawan kemanusiaan<br>
                    dalam membantu penanganan bencana:<br>
                    <span class="disaster-name">"{{ $penugasan->bencana->nama_bencana }}"</span><br>
                    yang berlokasi di <strong>{{ $penugasan->bencana->lokasi }}</strong> pada tanggal <strong>{{ $penugasan->tanggal_tugas->format('d-m-Y') }}</strong>.
                </div>

                {{-- Footer Table (Signatures & Verification Metadata) --}}
                <table class="cert-footer-table" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <!-- Left side: Monospace Verification Info -->
                        <td width="55%" class="metadata-section" valign="bottom">
                            No. Sertifikat: <span class="cert-code">{{ $kode }}</span><br>
                            Tanggal Terbit: {{ now()->format('d-m-Y') }}<br>
                            Verifikasi keaslian dokumen di:<br>
                            <span class="verification-url">kitatanggap.id/verifikasi/{{ $kode }}</span>
                        </td>
                        
                        <!-- Right side: Administrator signature placeholder -->
                        <td width="45%" align="right" valign="bottom">
                            <div class="sign-title">Koordinator Admin KitaTanggap,</div>
                            <div class="sign-name">Tim Admin KitaTanggap</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
