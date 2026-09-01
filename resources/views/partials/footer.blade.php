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

    <!-- Footer Bottom Area -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} <strong>PKBM Tahfizh At-Tamam</strong>. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>
</footer>

<!-- Floating Action Back-to-Top Rocket Button (Appears on Scroll) -->
<button type="button" class="floating-back-to-top" id="floatingBackToTop" aria-label="Kembali ke atas halaman" title="Kembali ke Atas">
    <svg class="scroll-progress-ring" viewBox="0 0 36 36">
        <path class="scroll-progress-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
        <path class="scroll-progress-bar" id="scrollProgressBar" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
    </svg>
    <span class="floating-btn-icon">🚀</span>
</button>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const floatingBtn = document.getElementById('floatingBackToTop');
    const progressBar = document.getElementById('scrollProgressBar');

    // 1. Scroll Progress & Floating Button Visibility
    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        
        if (floatingBtn) {
            if (scrollTop > 280) {
                floatingBtn.classList.add('is-visible');
            } else {
                floatingBtn.classList.remove('is-visible');
            }
        }

        if (progressBar && scrollHeight > 0) {
            const scrollPercentage = Math.min(100, Math.max(0, (scrollTop / scrollHeight) * 100));
            progressBar.setAttribute('stroke-dasharray', `${scrollPercentage.toFixed(1)}, 100`);
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    // 2. Rocket Launch & Particle Burst Animation
    function createLaunchParticles(originElement) {
        if (!originElement) return;
        const rect = originElement.getBoundingClientRect();
        const particleCount = 14;
        const colors = ['#00B4D8', '#38bdf8', '#34d399', '#f59e0b', '#ec4899', '#ffffff'];

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('span');
            particle.className = 'back-to-top-spark';
            
            const startX = rect.left + rect.width / 2;
            const startY = rect.top + rect.height / 2;
            
            const angle = (Math.PI * 2 * i) / particleCount + (Math.random() - 0.5);
            const distance = 25 + Math.random() * 55;
            const destX = Math.cos(angle) * distance;
            const destY = Math.sin(angle) * distance - 25; // Bias burst upwards
            const color = colors[Math.floor(Math.random() * colors.length)];
            const size = 3 + Math.random() * 5;

            particle.style.cssText = `
                position: fixed;
                left: ${startX}px;
                top: ${startY}px;
                width: ${size}px;
                height: ${size}px;
                background: ${color};
                border-radius: 50%;
                pointer-events: none;
                z-index: 999999;
                box-shadow: 0 0 10px ${color};
                transform: translate(-50%, -50%) scale(1);
                transition: transform 0.75s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.75s ease-out;
            `;

            document.body.appendChild(particle);

            requestAnimationFrame(() => {
                particle.style.transform = `translate(calc(-50% + ${destX}px), calc(-50% + ${destY}px)) scale(0)`;
                particle.style.opacity = '0';
            });

            setTimeout(() => {
                particle.remove();
            }, 800);
        }
    }

    // 3. Smooth Kinetic Momentum Scroll to Top
    function triggerRocketLaunch(btn) {
        if (!btn || btn.classList.contains('is-launching')) return;

        btn.classList.add('is-launching');
        createLaunchParticles(btn);

        const startPosition = window.pageYOffset || document.documentElement.scrollTop;
        const duration = Math.min(900, Math.max(450, startPosition * 0.35));
        let startTime = null;

        function easeOutQuart(t) {
            return 1 - (--t) * t * t * t;
        }

        function scrollStep(currentTime) {
            if (!startTime) startTime = currentTime;
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const ease = easeOutQuart(progress);

            window.scrollTo(0, startPosition * (1 - ease));

            if (progress < 1) {
                requestAnimationFrame(scrollStep);
            } else {
                window.scrollTo(0, 0);
            }
        }

        requestAnimationFrame(scrollStep);

        // Reset button state after launch completion
        setTimeout(() => {
            btn.classList.remove('is-launching');
        }, 1000);
    }

    if (floatingBtn) {
        floatingBtn.addEventListener('click', function () {
            triggerRocketLaunch(floatingBtn);
        });
    }
});
</script>
@endpush
