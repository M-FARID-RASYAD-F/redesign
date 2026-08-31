<footer class="footer">
    <div class="footer-container">
        <!-- Col 1: About -->
        <div>
            <div class="footer-brand-name">SMK Negeri 1 Nusantara</div>
            <div class="footer-brand-tagline">Unggul · Kompeten · Berkarakter</div>
            <p style="font-size: 0.9rem; line-height: 1.7; margin-bottom: 1.5rem;">
                Sekolah menengah kejuruan pilihan terbaik yang berdedikasi mencetak tenaga kerja profesional, wirausahawan muda, dan generasi unggul siap bersaing global.
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
