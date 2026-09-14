<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir PPDB - {{ $reg->no_pendaftaran }} - {{ $reg->full_name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background-color: #ffffff;
            padding: 24px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #cbd5e1;
            padding: 28px 32px;
            border-radius: 8px;
            background: #ffffff;
        }
        .kop-header {
            display: flex;
            align-items: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 14px;
            margin-bottom: 20px;
            gap: 16px;
        }
        .kop-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 2px;
        }
        .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-text h2 {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .kop-text h3 {
            font-size: 13px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 4px;
        }
        .kop-text p {
            font-size: 11px;
            color: #64748b;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 22px;
        }
        .doc-title h1 {
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #0f172a;
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
            padding-bottom: 4px;
        }
        .doc-title .reg-badge {
            margin-top: 6px;
            font-size: 12px;
            color: #475569;
        }
        .section-box {
            margin-bottom: 18px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .section-header {
            background: #f1f5f9;
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-table {
            width: 100%;
            border-collapse: collapse;
        }
        .section-table td {
            padding: 8px 14px;
            font-size: 12.5px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }
        .section-table tr:last-child td {
            border-bottom: none;
        }
        .section-table td.label-col {
            width: 32%;
            font-weight: 600;
            color: #475569;
            background: #fafafa;
        }
        .section-table td.value-col {
            width: 68%;
            color: #0f172a;
            font-weight: 500;
        }
        .status-tag {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-pending { background: #fef3c7; color: #b45309; }
        .status-diverifikasi { background: #e0f2fe; color: #0369a1; }
        .status-diterima { background: #dcfce7; color: #15803d; }
        .status-ditolak { background: #fee2e2; color: #b91c1c; }

        .docs-table {
            width: 100%;
            border-collapse: collapse;
        }
        .docs-table th {
            background: #f8fafc;
            padding: 8px 12px;
            font-size: 11.5px;
            font-weight: 700;
            text-align: left;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }
        .docs-table td {
            padding: 8px 12px;
            font-size: 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .docs-table tr:last-child td {
            border-bottom: none;
        }

        .ttd-grid {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 10px;
        }
        .ttd-box {
            width: 45%;
            text-align: center;
        }
        .ttd-box p {
            font-size: 12px;
            color: #475569;
            margin-bottom: 60px;
        }
        .ttd-box .ttd-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }

        @media print {
            body { padding: 0; background: transparent; }
            .container { border: none; padding: 0; }
            @page { margin: 1.5cm; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- KOP SEKOLAH -->
        <div class="kop-header">
            <div class="kop-text">
                <h2>PKBM TAHFIZH AT-TAMAM</h2>
                <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB) ONLINE</h3>
                <p>Mencetak Generasi Qur'ani, Unggul & Berkarakter Berbasis Vokasi Modern</p>
                <p>Website: attamam.sch.id &bull; Tahun Ajaran 2026/2027</p>
            </div>
        </div>

        <!-- JUDUL DOKUMEN -->
        <div class="doc-title">
            <h1>LEMBAR FORMULIR & VERIFIKASI PENDAFTARAN</h1>
            <div class="reg-badge">
                Nomor Registrasi: <strong>{{ $reg->no_pendaftaran }}</strong> &bull; Waktu Mendaftar: {{ $reg->created_at ? $reg->created_at->format('d F Y, H:i') . ' WIB' : '-' }}
            </div>
        </div>

        <!-- 1. DATA SELEKSI PENDAFTARAN -->
        <div class="section-box">
            <div class="section-header">
                <span>Informasi Pilihan & Status Seleksi</span>
                <span class="status-tag status-{{ strtolower($reg->status) }}">
                    Status: {{ ucfirst($reg->status) }}
                </span>
            </div>
            <table class="section-table">
                <tr>
                    <td class="label-col">Jenjang Pendidikan</td>
                    <td class="value-col"><strong>{{ $reg->jenjang_label }} ({{ strtoupper($reg->jenjang) }})</strong></td>
                </tr>
                @if($reg->jenjang === 'smk')
                <tr>
                    <td class="label-col">Program Keahlian / Jurusan</td>
                    <td class="value-col"><strong style="color: #2563eb;">{{ $reg->major_choice ?: 'Belum memilih jurusan' }}</strong></td>
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
            <div class="section-header">
                <span>Biodata Calon Peserta Didik</span>
            </div>
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
            <div class="section-header">
                <span>Data Orang Tua / Wali Murid</span>
            </div>
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
            <div class="section-header">
                <span>Daftar Berkas Persyaratan Yang Diunggah</span>
                <span style="font-size: 11px; font-weight: normal; color: #64748b;">(Semua file tersedia dalam folder ini)</span>
            </div>
            <table class="docs-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%;">Jenis Dokumen</th>
                        <th style="width: 25%;">Status Unggah</th>
                        <th style="width: 30%;">Nama Berkas di Folder</th>
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
                        $docsByTipe = $reg->documents->keyBy('doc_type');
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
                                    <span style="color: #15803d; font-weight: 700;">✓ Dilampirkan</span>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">— Tidak dilampirkan</span>
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
                                            'rapor_terakhir' => 'Berkas_Rapor.' . $ext,
                                            default => 'Berkas_' . $key . '.' . $ext
                                        };
                                    @endphp
                                    <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 11px;">{{ $fileName }}</code>
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
        <div class="ttd-grid">
            <div class="ttd-box">
                <p>Orang Tua / Wali Calon Siswa,</p>
                <div class="ttd-name">({{ $reg->parent_name }})</div>
            </div>
            <div class="ttd-box">
                <p>Pekanbaru, {{ date('d F Y') }}<br>Panitia Penerimaan Siswa Baru,</p>
                <div class="ttd-name">( Tim Administrasi PPDB )</div>
            </div>
        </div>
    </div>
</body>
</html>
