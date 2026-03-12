<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Surat Persetujuan Peminjaman</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 40px;
        }

        /* HEADER */
        .header {
            text-align: center;
            border-bottom: 3px solid #135bec;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #135bec;
        }

        .subtitle {
            font-size: 13px;
            color: #666;
        }

        .title {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        /* CONTENT */
        .content {
            margin-top: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-table td {
            padding: 8px 4px;
            border-bottom: 1px solid #eee;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 10px;
        }

        /* PARAGRAPH */
        .desc {
            margin-top: 20px;
            text-align: justify;
        }

        /* SIGNATURE */
        .signature-section {
            margin-top: 70px;
            width: 100%;
        }

        .signature-table {
            width: 100%;
            text-align: center;
        }

        .signature-table td {
            width: 50%;
            vertical-align: top;
        }

        .signature-space {
            height: 80px;
        }

        .signature-name {
            font-weight: bold;
        }

        .date {
            text-align: right;
            margin-top: 40px;
        }
    </style>


</head>

<body>
    <div class="header">
        <div class="logo">KantorKuu</div>
        <div class="subtitle">Sistem Manajemen Peminjaman Alat</div>
    </div>

    <div class="title">
        Surat Persetujuan Peminjaman Alat
    </div>

    <div class="content">

        <p>
            Dengan ini menerangkan bahwa permohonan peminjaman alat berikut telah disetujui:
        </p>

        <table class="info-table">

            <tr>
                <td>Nama Peminjam</td>
                <td>:</td>
                <td>{{ $borrowing->user->name }}</td>
            </tr>

            <tr>
                <td>Nama Alat</td>
                <td>:</td>
                <td>{{ $borrowing->tool->name }}</td>
            </tr>

            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td>{{ $borrowing->qty }} Unit</td>
            </tr>

            <tr>
                <td>Tanggal Pinjam</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d F Y') }}</td>
            </tr>

            <tr>
                <td>Tanggal Kembali</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d F Y') }}</td>
            </tr>

        </table>

        <p class="desc">
            Peminjam diharapkan menjaga alat yang dipinjam dengan baik serta mengembalikannya sesuai dengan
            waktu yang telah ditentukan. Apabila terjadi kerusakan atau keterlambatan pengembalian,
            maka peminjam bersedia menerima sanksi sesuai dengan ketentuan yang berlaku.
        </p>

    </div>

    <div class="date">
        Disetujui pada: {{ now()->format('d F Y H:i') }}
    </div>

    <div class="signature-section">

        <table class="signature-table">

            <tr>

                <td>
                    Peminjam
                    <div class="signature-space"></div>
                    <div class="signature-name">
                        ( {{ $borrowing->user->name }} )
                    </div>
                </td>

                <td>
                    Petugas KantorKuu
                    <div class="signature-space"></div>
                    <div class="signature-name">
                        ( ____________________ )
                    </div>
                </td>

            </tr>

        </table>

    </div>
</body>

</html>