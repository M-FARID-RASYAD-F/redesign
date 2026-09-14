<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulir PPDB - {{ $reg->no_pendaftaran }} - {{ $reg->full_name }}</title>
    <style>
        @page {
            margin: 12mm 15mm 12mm 15mm;
            size: a4 portrait;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10.5px;
            line-height: 1.4;
            color: #1e293b;
            background-color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header-table h2 {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .header-table h3 {
            font-size: 11px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 3px;
        }
        .header-table p {
            font-size: 9px;
            color: #475569;
            line-height: 1.3;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title h1 {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
            padding-bottom: 2px;
            margin-bottom: 3px;
        }
        .doc-title .reg-badge {
            font-size: 9.5px;
            color: #475569;
        }
        .section-box {
            margin-bottom: 10px;
            border: 1px solid #cbd5e1;
            page-break-inside: avoid;
        }
        .section-header-table {
            background-color: #f1f5f9;
            border-bottom: 1px solid #cbd5e1;
        }
        .section-header-table td {
            padding: 5px 10px;
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
        }
        .section-table {
            width: 100%;
            border-collapse: collapse;
        }
        .section-table td {
            padding: 5px 10px;
            font-size: 10px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }
        .section-table tr:last-child td {
            border-bottom: none;
        }
        .section-table td.label-col {
            width: 32%;
            font-weight: bold;
            color: #475569;
            background-color: #f8fafc;
            border-right: 1px solid #f1f5f9;
        }
        .section-table td.value-col {
            width: 68%;
            color: #0f172a;
        }
        .status-tag {
            display: inline-block;
            padding: 2px 7px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 3px;
        }
        .status-pending { background-color: #fef3c7; color: #b45309; }
        .status-diverifikasi { background-color: #e0f2fe; color: #0369a1; }
        .status-diterima { background-color: #dcfce7; color: #15803d; }
        .status-ditolak { background-color: #fee2e2; color: #b91c1c; }

        .docs-table {
            width: 100%;
            border-collapse: collapse;
        }
        .docs-table th {
            background-color: #f8fafc;
            padding: 4px 8px;
            font-size: 9.5px;
            font-weight: bold;
            color: #475569;
            border-bottom: 1px solid #cbd5e1;
            text-align: left;
        }
        .docs-table td {
            padding: 4px 8px;
            font-size: 9.5px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .docs-table tr:last-child td {
            border-bottom: none;
        }
        .ttd-table {
            width: 100%;
            margin-top: 18px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-title {
            font-size: 10px;
            color: #475569;
            margin-bottom: 45px;
        }
        .ttd-name {
            font-size: 10.5px;
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
        }
    </style>
</head>
<body>
    <!-- KOP SEKOLAH -->
    <table class="header-table">
        <tr>
            <td style="text-align: center;">
                <h2>PKBM TAHFIZH AT-TAMAM</h2>
                <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB) ONLINE</h3>
                <p>Mencetak Generasi Qur'ani, Unggul &amp; Berkarakter Berbasis Vokasi Modern</p>
                <p>Website: attamam.sch.id &bull; Tahun Ajaran 2026/2027</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL DOKUMEN -->
    <div class="doc-title">
        <h1>LEMBAR FORMULIR &amp; VERIFIKASI PENDAFTARAN</h1>
        <div class="reg-badge">
            Nomor Registrasi: <strong>{{ $reg->no_pendaftaran }}</strong> &bull; Waktu Mendaftar: {{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') . ' WIB' : '-' }}
        </div>
    </div>

    <!-- 1. DATA SELEKSI PENDAFTARAN -->
    <div class="section-box">
        <table class="section-header-table">
            <tr>
                <td>Informasi Pilihan &amp; Status Seleksi</td>
                <td style="text-align: right;">
                    <span class="status-tag status-{{ strtolower($reg->status) }}">
                        Status: {{ ucfirst($reg->status) }}
                    </span>
                </td>
            </tr>
        </table>
        <table class="section-table">
            <tr>
                <td class="label-col">Jenjang Pendidikan</td>
                <td class="value-col"><strong>{{ $reg->jenjang_label }} ({{ strtoupper($reg->jenjang) }})</strong></td>
            </tr>
            @if($reg->jenjang === 'smk')
            <tr>
                <td class="label-col">Program Keahlian / Jurusan</td>
                <td class="value-col"><strong style="color: #1d4ed8;">{{ $reg->major_choice ?: 'Belum memilih jurusan' }}</strong></td>
            </tr>
            @endif
            <tr>
                <td class="label-col">Catatan Panitia PPDB</td>
                <td class="value-col">{{ $reg->notes ?: 'Belum ada catatan panitia.' }}</td>
            </tr>
        </table>
    </div>

    <!-- 2. DATA CALON PESERTA DIDIK -->
    <div class="section-box">
        <table class="section-header-table">
            <tr>
                <td colspan="2">Biodata Calon Peserta Didik</td>
            </tr>
        </table>
        <table class="section-table">
            <tr>
                <td class="label-col">Nama Lengkap Siswa</td>
                <td class="value-col"><strong>{{ $reg->full_name }}</strong></td>
            </tr>
            <tr>
                <td class="label-col">Jenis Kelamin</td>
                <td class="value-col">{{ $reg->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="label-col">Tanggal Lahir</td>
                <td class="value-col">{{ $reg->birth_date ? $reg->birth_date->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label-col">Alamat Domisili</td>
                <td class="value-col">{{ $reg->address }}</td>
            </tr>
        </table>
    </div>

    <!-- 3. DATA ORANG TUA / WALI -->
    <div class="section-box">
        <table class="section-header-table">
            <tr>
                <td colspan="2">Data Orang Tua / Wali Murid</td>
            </tr>
        </table>
        <table class="section-table">
            <tr>
                <td class="label-col">Nama Orang Tua / Wali</td>
                <td class="value-col">{{ $reg->parent_name }}</td>
            </tr>
            <tr>
                <td class="label-col">Nomor Telepon / WhatsApp</td>
                <td class="value-col">{{ $reg->parent_phone }}</td>
            </tr>
        </table>
    </div>

    <!-- 4. BERKAS PERSYARATAN TERLAMPIR -->
    <div class="section-box">
        <table class="section-header-table">
            <tr>
                <td>Daftar Berkas Persyaratan Terlampir Di Folder Ini</td>
                <td style="text-align: right; font-weight: normal; font-size: 9px; color: #64748b; text-transform: none;">
                    (Semua file tersedia dalam folder siswa)
                </td>
            </tr>
        </table>
        <table class="docs-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 38%;">Jenis Dokumen</th>
                    <th style="width: 25%;">Status Unggah</th>
                    <th style="width: 32%;">Nama Berkas di Folder</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $docTypes = [
                        'kk' => 'Kartu Keluarga (KK)',
                        'akta_lahir' => 'Akta Kelahiran',
                        'foto' => 'Pas Foto Formal (3x4)',
                        'rapor_terakhir' => 'Rapor Pendidikan Terakhir',
                    ];
                    $docsByTipe = $reg->documents ? $reg->documents->keyBy('doc_type') : collect();
                @endphp
                @foreach($docTypes as $key => $label)
                    @php
                        $doc = $docsByTipe->get($key);
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td><strong>{{ $label }}</strong></td>
                        <td>
                            @if($doc)
                                <span style="display: inline-block; background-color: #dcfce7; color: #15803d; padding: 2px 6px; border-radius: 3px; font-weight: bold; font-size: 8.5px;">ADA (DILAMPIRKAN)</span>
                            @else
                                <span style="display: inline-block; background-color: #f1f5f9; color: #94a3b8; padding: 2px 6px; border-radius: 3px; font-size: 8.5px;">TIDAK ADA</span>
                            @endif
                        </td>
                        <td>
                            @if($doc)
                                @php
                                    $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION) ?: 'pdf';
                                    $fileName = match($key) {
                                        'kk' => 'Berkas_Kartu_Keluarga.' . $ext,
                                        'akta_lahir' => 'Berkas_Akta_Kelahiran.' . $ext,
                                        'foto' => 'Pas_Foto.' . $ext,
                                        'rapor_terakhir' => 'Berkas_Rapor_Terakhir.' . $ext,
                                        default => 'Berkas_' . $key . '.' . $ext
                                    };
                                @endphp
                                <span style="background-color: #f1f5f9; padding: 1px 4px; font-family: monospace; font-size: 9px;">{{ $fileName }}</span>
                            @else
                                <span style="color: #94a3b8;">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td>
                <p class="ttd-title">Orang Tua / Wali Calon Siswa,</p>
                <div class="ttd-name">(&nbsp;{{ $reg->parent_name ?: '.........................................' }}&nbsp;)</div>
            </td>
            <td>
                <p class="ttd-title">Pekanbaru, {{ date('d F Y') }}<br>Panitia Penerimaan Siswa Baru,</p>
                <div class="ttd-name">(&nbsp;Tim Administrasi PPDB&nbsp;)</div>
            </td>
        </tr>
    </table>
</body>
</html>
