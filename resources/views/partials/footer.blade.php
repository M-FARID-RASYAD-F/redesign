<footer class="footer">
    <div class="footer-container">
        <!-- Col 1: About -->
        <div>
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                <div style="width: 48px; height: 48px; background: #ffffff; border-radius: 10px; padding: 3px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2px solid rgba(0, 180, 216, 0.4); flex-shrink: 0;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam" style="width: 100%; height: 100%; object-fit: contain; border-radius: 6px;">
                </div>
                <div>
                    <div class="footer-brand-name" style="margin-bottom: 2px;">PKBM Tahfizh At-Tamam</div>
                    <div class="footer-brand-tagline">Unggul · Berkarakter · Qur'ani</div>
                </div>
            </div>
            <p style="font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.5rem;">
                Lembaga pendidikan Islam & kejuruan terkemuka yang berdedikasi mencetak generasi penghafal Al-Qur'an yang unggul, kompeten di bidang kejuruan modern, dan berakhlak mulia.
            </p>
            <p style="font-size: 0.85rem; color: #64748b;">
                📍 Jl. Pendidikan Teknologi No. 45, Cyber City, Nusantara<br>
                📞 (021) 555-0192 | ✉️ info@smkn1nusantara.sch.id
            </p>
        </div>

        <!-- Col 2: Quick Links -->
        <div>
            <h3 class="footer-title">Navigasi Sekolah</h3>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}">Beranda Utama</a></li>
                <li><a href="{{ route('ppdb.index') }}">Portal PPDB Online</a></li>
                <li><a href="{{ route('ppdb.create') }}">Formulir Pendaftaran Siswa Baru</a></li>
                <li><a href="{{ route('ppdb.tracking') }}">Lacak Status Pendaftaran</a></li>
                <li><a href="{{ route('home') }}#berita">Kabar & Berita Terbaru</a></li>
            </ul>
        </div>

        <!-- Col 3: Media & Program -->
        <div>
            <h3 class="footer-title">Program Kejuruan</h3>
            <ul class="footer-links">
                <li><a href="{{ route('home') }}#jurusan">Rekayasa Perangkat Lunak (RPL)</a></li>
                <li><a href="{{ route('home') }}#jurusan">Teknik Komputer & Jaringan (TKJ)</a></li>
                <li><a href="{{ route('home') }}#jurusan">Desain Komunikasi Visual (DKV)</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} <strong>SMK Negeri 1 Nusantara</strong>. Semua hak cipta dilindungi.</p>
    </div>
</footer>
