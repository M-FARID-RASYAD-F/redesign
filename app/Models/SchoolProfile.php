<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $table = 'school_profile';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Default nilai fallback jika database belum di-seed
     */
    public static function defaultValues(?string $key = null)
    {
        $defaults = [
            'general' => [
                'nama' => 'PKBM TAHFIZH ATTAMAM',
                'slogan' => 'Mencetak Generasi Qurani, Berkarakter & Siap Kerja di Era Digital',
                'deskripsi' => 'Pusat Kegiatan Belajar Masyarakat (PKBM) terpadu berbasis Tahfizh Al-Qur\'an dan kejuruan teknologi modern untuk seluruh jenjang pendidikan (SD, SMP, SMK).',
                'tahun_berdiri' => '2018',
                'akreditasi' => 'B (Baik)',
                'alamat' => 'Jl. Hangtuah No. 45, Rejosari, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28281',
                'telepon' => '(0761) 555-0192',
                'email' => 'info@pkbmtahfizhattamam.sch.id',
            ],

            'sambutan' => [
                'nama' => 'Dr. H. Ahmad Fauzi, M.Pd.',
                'jabatan' => 'Kepala Sekolah PKBM Tahfizh At-Tamam',
                'pesan' => 'Selamat datang di portal resmi PKBM Tahfizh At-Tamam. Kami berdedikasi menciptakan lingkungan belajar Qurani yang inspiratif, berkarakter, dan relevan dengan kebutuhan dunia kerja masa depan. Mari bersama mewujudkan impian dan potensi terbaik para peserta didik!',
                'foto_initials' => 'AF',
            ],

            'stats' => [
                'siswa_baseline' => 1250, // Baseline historis/marketing pendaftar
                'guru_fallback' => 85,
                'serapan_prestasi' => '96% Sukses',
                'jenjang_label' => '3 Jenjang (SD, SMP, SMK)',
            ],

            'cabang' => [
                [
                    'id' => 'kampus-pusat',
                    'label' => 'Kampus Pusat',
                    'title' => 'Kampus Utama & Pusat Tahfizh At-Tamam',
                    'tag' => 'KAMPUS PUSAT & ASRAMA',
                    'kota' => 'Tenayan Raya, Pekanbaru',
                    'alamat' => 'Jl. Hangtuah No. 45, Rejosari, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28281',
                    'jam' => 'Senin – Sabtu: 07.30 – 16.30 WIB',
                    'telepon' => '(0761) 555-0192',
                    'wa' => '0812-7000-1920',
                    'wa_url' => 'https://wa.me/6281270001920?text=Halo%20Admin%20Kampus%20Pusat%20At-Tamam,%20saya%20ingin%20informasi%20pendaftaran',
                    'maps_url' => 'https://maps.google.com/?q=PKBM+Tahfizh+At-Tamam+Pekanbaru',
                    'desc' => 'Pusat pendidikan terpadu At-Tamam yang menaungi program Tahfizh Qur\'an intensif 30 juz, asrama santri modern putra/putri, serta kejuruan rekayasa perangkat lunak dengan fasilitas terlengkap.',
                    'image' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop',
                    'features' => [
                        'Asrama Santri Nyaman & Ber-AC',
                        'Masjid Jami\' At-Tamam 500 Jamaah',
                        'Lab Komputer High-End 120 Unit PC',
                        'Studio Podcast & Broadcast Kreatif',
                        'Klinik Kesehatan Santri & Kantin',
                        'Free WiFi High-Speed Fiber 1 Gbps',
                    ],
                ],
                [
                    'id' => 'cabang-panam',
                    'label' => 'Cabang Panam',
                    'title' => 'Cabang Panam — Sentra Teknologi & Kejuruan',
                    'tag' => 'SENTRA IT & MULTIMEDIA',
                    'kota' => 'Tampan / Panam, Pekanbaru',
                    'alamat' => 'Jl. HR. Soebrantas Km. 12, Kel. Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293',
                    'jam' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
                    'telepon' => '(0761) 555-0193',
                    'wa' => '0812-7000-1921',
                    'wa_url' => 'https://wa.me/6281270001921?text=Halo%20Admin%20Cabang%20Panam%20At-Tamam,%20saya%20ingin%20tanya%20program%20kejuruan%20dan%20tahfizh',
                    'maps_url' => 'https://maps.google.com/?q=HR+Soebrantas+Panam+Pekanbaru',
                    'desc' => 'Sentra kejuruan digital & multimedia At-Tamam yang dirancang khusus untuk mencetak developer muda, teknisi jaringan bersertifikasi Cisco/Mikrotik, serta talenta kreatif animasi.',
                    'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1200&auto=format&fit=crop',
                    'features' => [
                        'Smart Interactive Classrooms',
                        'Laboratorium Cyber Security & Jaringan',
                        'Studio Desain Komunikasi Visual (DKV)',
                        'Co-Working Space Siswa Ber-AC',
                        'Program Sertifikasi Industri Resmi',
                        'Area Parkir Luas & Akses Strategis',
                    ],
                ],
                [
                    'id' => 'cabang-marpoyan',
                    'label' => 'Cabang Marpoyan',
                    'title' => 'Cabang Marpoyan — Tahfizh & Kewirausahaan',
                    'tag' => 'TAHFIZH & ENTREPRENEUR',
                    'kota' => 'Marpoyan Damai, Pekanbaru',
                    'alamat' => 'Jl. Kaharuddin Nasution No. 88, Kel. Maharatu, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28284',
                    'jam' => 'Senin – Sabtu: 07.30 – 16.30 WIB',
                    'telepon' => '(0761) 555-0194',
                    'wa' => '0812-7000-1922',
                    'wa_url' => 'https://wa.me/6281270001922?text=Halo%20Admin%20Cabang%20Marpoyan%20At-Tamam,%20saya%20ingin%20konsultasi%20program%20tahfizh%20dan%20wirausaha',
                    'maps_url' => 'https://maps.google.com/?q=Marpoyan+Damai+Pekanbaru',
                    'desc' => 'Kampus asri bernuansa green campus yang menitikberatkan pada hafalan Al-Qur\'an bersanad mutqin, pembinaan adab santri, serta pelatihan kewirausahaan digital dan bisnis mandiri.',
                    'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1200&auto=format&fit=crop',
                    'features' => [
                        'Ruang Halaqah Al-Qur\'an Sejuk & Asri',
                        'Arena Olahraga Sunnah (Panahan)',
                        'Aula Pertemuan Serbaguna (300 Seat)',
                        'Perpustakaan & Pojok Literasi Islam',
                        'Greenhouse Edukasi Botani & Agribisnis',
                        'Pengawasan Keamanan CCTV 24 Jam',
                    ],
                ],
                [
                    'id' => 'cabang-rumbai',
                    'label' => 'Cabang Rumbai',
                    'title' => 'Cabang Rumbai — Sentra Bahasa & Sains',
                    'tag' => 'SAINS & BAHASA DUNIA',
                    'kota' => 'Rumbai, Pekanbaru',
                    'alamat' => 'Jl. Yos Sudarso No. 102, Kel. Lembah Damai, Kec. Rumbai, Kota Pekanbaru, Riau 28265',
                    'jam' => 'Senin – Sabtu: 08.00 – 16.30 WIB',
                    'telepon' => '(0761) 555-0195',
                    'wa' => '0812-7000-1923',
                    'wa_url' => 'https://wa.me/6281270001923?text=Halo%20Admin%20Cabang%20Rumbai%20At-Tamam,%20saya%20ingin%20informasi%20program%20bilingual%20dan%20paket%20belajar',
                    'maps_url' => 'https://maps.google.com/?q=Rumbai+Pekanbaru',
                    'desc' => 'Kampus percontohan pengembangan kompetensi dwibahasa (Arab & Inggris aktif) yang terintegrasi dengan pembelajaran sains terapan, kelas fleksibel kesetaraan Paket B/C, dan tahfizh akhir pekan.',
                    'image' => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?q=80&w=1200&auto=format&fit=crop',
                    'features' => [
                        'Laboratorium Bahasa Digital Interaktif',
                        'Pusat Belajar Paket Kesetaraan Fleksibel',
                        'Ruang Multimedia & Presentasi Audio',
                        'Musholla Kampus yang Bersih & Luas',
                        'Area Diskusi Terbuka Siswa Berpohon',
                        'Konseling & Bimbingan Minat Karir',
                    ],
                ],
            ],

            'jenjang' => [
                [
                    'id' => 'sd',
                    'kode' => 'SD',
                    'nama' => 'Sekolah Dasar (SD)',
                    'kategori' => 'Pendidikan Dasar & Karakter',
                    'badge' => '🌱 Fondasi Qurani',
                    'deskripsi' => 'Membangun aqidah shohihah, adab islami, tahfizh juz 30 mutqin, serta dasar literasi, numerasi, dan sains eksploratif dengan suasana belajar aktif.',
                    'masa_studi' => '6 Tahun',
                    'fokus_kurikulum' => 'Tahfizh & Adab',
                    'keunggulan_label' => '🎯 Program Unggulan:',
                    'keunggulan' => 'Tahfizh Cilik, Bilingual Dasar, Islamic Character Building, Fun Science & Math',
                    'icon' => '🎒',
                ],
                [
                    'id' => 'smp',
                    'kode' => 'SMP',
                    'nama' => 'Sekolah Menengah Pertama (SMP)',
                    'kategori' => 'Pendidikan Menengah & Riset',
                    'badge' => '🌟 Karakter & Sains Terapan',
                    'deskripsi' => 'Penguatan tahfizh Al-Qur\'an berkesinambungan, pembentukan kepemimpinan santri, penguasaan sains terapan, serta pengenalan dasar teknologi digital.',
                    'masa_studi' => '3 Tahun',
                    'fokus_kurikulum' => 'Tahfizh & Sains',
                    'keunggulan_label' => '🎯 Program Unggulan:',
                    'keunggulan' => 'Target 5–10 Juz Mutqin, Arabic & English Club, Basic Coding, Leadership Camp',
                    'icon' => '📚',
                ],
                [
                    'id' => 'smk',
                    'kode' => 'SMK',
                    'nama' => 'Sekolah Menengah Kejuruan (SMK)',
                    'kategori' => 'Pendidikan Vokasi & Siap Kerja',
                    'badge' => '🚀 Keahlian Industri & Digital',
                    'deskripsi' => 'Membekali keterampilan kejuruan vokasi berstandar industri (RPL, TKJ, DKV), sertifikasi BNSP/LSP, kurikulum industri, serta magang kerja nyata.',
                    'masa_studi' => '3 Tahun',
                    'fokus_kurikulum' => 'Industri & Vokasi',
                    'keunggulan_label' => '🎯 Program Unggulan:',
                    'keunggulan' => 'Kelas Industri (RPL, TKJ, DKV), Magang Kerja (PKL), Sertifikasi BNSP, Inkubator Bisnis',
                    'icon' => '💻',
                ],
            ],
        ];

        if ($key !== null) {
            return $defaults[$key] ?? null;
        }

        return $defaults;
    }

    /**
     * Ambil nilai konfigurasi dari tabel school_profile berdasarkan key.
     * Jika berupa JSON valid, otomatis di-decode menjadi array.
     * Jika tidak ditemukan di DB, ambil fallback dari defaultValues().
     */
    public static function getVal(string $key, $default = null)
    {
        $fallback = $default ?? static::defaultValues($key);

        try {
            $record = static::where('key', $key)->first();
            if (!$record || $record->value === null) {
                return $fallback;
            }

            $decoded = json_decode($record->value, true);
            if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_numeric($decoded) || is_bool($decoded))) {
                return $decoded;
            }

            return $record->value;
        } catch (\Throwable $e) {
            return $fallback;
        }
    }

    /**
     * Simpan atau perbarui nilai konfigurasi profil sekolah.
     * Jika value berupa array, otomatis di-encode ke JSON.
     */
    public static function setVal(string $key, $value): static
    {
        $valStr = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : (string) $value;

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $valStr]
        );
    }
}
