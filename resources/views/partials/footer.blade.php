<footer class="footer">
    <div class="footer-container">
        <!-- Col 1: Brand, Deskripsi, Badge & Kontak Interaktif -->
        <div class="footer-col-brand">
            <div class="footer-brand-header">
                <div class="footer-logo-box">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam" class="footer-logo-img">
                </div>
                <div class="footer-brand-text">
                    <div class="footer-brand-name">PKBM Tahfizh At-Tamam</div>
                    <div class="footer-brand-tagline">Unggul · Berkarakter · Qur'ani</div>
                </div>
            </div>

            <p class="footer-description">
                Lembaga pendidikan Islam & kejuruan terkemuka yang berdedikasi mencetak generasi penghafal Al-Qur'an yang unggul, kompeten di bidang teknologi modern, dan berakhlak mulia.
            </p>

            <!-- Pill Badges -->
            <div class="footer-badges">
                <span class="footer-badge">🌟 Akreditasi B</span>
                <span class="footer-badge">📖 Tahfizh Qur'an</span>
                <span class="footer-badge">🚀 Berbasis Industri</span>
            </div>

            <!-- Quick Interactive Contact Buttons / Chips -->
            <div class="footer-contact-list">
                <a href="https://maps.google.com/?q=PKBM+Tahfizh+At-Tamam" target="_blank" rel="noopener noreferrer" class="footer-contact-item" title="Buka Lokasi di Google Maps">
                    <span class="footer-contact-icon">📍</span>
                    <span class="footer-contact-text">Jl. Pendidikan Teknologi No. 45, Cyber City</span>
                </a>
                <div class="footer-contact-row">
                    <a href="tel:0215550192" class="footer-contact-item" title="Hubungi Telepon">
                        <span class="footer-contact-icon">📞</span>
                        <span class="footer-contact-text">(021) 555-0192</span>
                    </a>
                    <a href="mailto:info@pkbmtahfizhattamam.sch.id" class="footer-contact-item" title="Kirim Email">
                        <span class="footer-contact-icon">✉️</span>
                        <span class="footer-contact-text">info@pkbmtahfizhattamam.sch.id</span>
                    </a>
                </div>
                <a href="https://wa.me/6281200000000?text=Halo%20Admin%20PKBM%20Tahfizh%20At-Tamam,%20saya%20ingin%20konsultasi%20pendaftaran" target="_blank" rel="noopener noreferrer" class="footer-contact-item footer-contact-item-highlight" title="Chat WhatsApp Sekolah">
                    <span class="footer-contact-icon">💬</span>
                    <span class="footer-contact-text">Chat WhatsApp Panitia PPDB (Fast Response)</span>
                </a>
            </div>
        </div>

        <!-- Col 2 & 3 Subgrid: Navigasi Sekolah & Program Kejuruan -->
        <div class="footer-nav-grid">
            <!-- Navigasi Utama -->
            <div class="footer-col-links">
                <h3 class="footer-title">
                    <span class="footer-title-icon">🧭</span> Navigasi Sekolah
                </h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#beranda"><span class="footer-link-arrow">›</span> Beranda Utama</a></li>
                    <li><a href="{{ route('ppdb.index') }}"><span class="footer-link-arrow">›</span> Portal PPDB Online</a></li>
                    <li><a href="{{ route('ppdb.create') }}"><span class="footer-link-arrow">›</span> Formulir Pendaftaran</a></li>
                    <li><a href="{{ route('ppdb.tracking') }}"><span class="footer-link-arrow">›</span> Lacak Status PPDB</a></li>
                    <li><a href="{{ route('home') }}#berita"><span class="footer-link-arrow">›</span> Kabar & Berita Terbaru</a></li>
                </ul>
            </div>

            <!-- Program Kejuruan & Unggulan -->
            <div class="footer-col-links">
                <h3 class="footer-title">
                    <span class="footer-title-icon">🎓</span> Program Unggulan
                </h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#jurusan"><span class="footer-link-arrow">›</span> Rekayasa Perangkat Lunak</a></li>
                    <li><a href="{{ route('home') }}#jurusan"><span class="footer-link-arrow">›</span> Teknik Komputer & Jaringan</a></li>
                    <li><a href="{{ route('home') }}#jurusan"><span class="footer-link-arrow">›</span> Desain Komunikasi Visual</a></li>
                    <li><a href="{{ route('home') }}#sambutan"><span class="footer-link-arrow">›</span> Program Tahfizh Intensif</a></li>
                    <li><a href="{{ route('home') }}#fasilitas"><span class="footer-link-arrow">›</span> Fasilitas Modern</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer Bottom Area with Back to Top Button -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} <strong>PKBM Tahfizh At-Tamam</strong>. Semua hak cipta dilindungi.
            </p>
            <div class="footer-bottom-actions">
                <button type="button" class="footer-back-to-top" id="footerBackToTop" aria-label="Kembali ke bagian atas halaman">
                    <span class="back-to-top-icon">↑</span>
                    <span class="back-to-top-text">Kembali ke Atas</span>
                </button>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const backToTopBtn = document.getElementById('footerBackToTop');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>
@endpush
