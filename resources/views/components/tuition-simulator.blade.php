{{-- ═══════════════════════════════════════════════════════════
     KOMPONEN SIMULASI BIAYA & BEASISWA PPDB ONLINE
     PKBM Tahfizh At-Tamam Edu
     ═══════════════════════════════════════════════════════════ --}}
<div class="tuition-simulator-wrapper" id="simulasi-biaya">
    <div class="tuition-sim-container">
        
        <div class="tuition-sim-header">
            <div class="tuition-sim-tag-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path><path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path></svg>
                <span>Transparansi Biaya &amp; Beasiswa</span>
            </div>
            <h2 class="tuition-sim-title">Kalkulator Estimasi Biaya &amp; Beasiswa PPDB</h2>
            <p class="tuition-sim-subtitle">
                Hitung estimasi rincian biaya pendidikan dan periksa hak beasiswa hafalan Al-Qur'an atau prestasi akademik calon santri secara instan.
            </p>
        </div>

        <div class="tuition-sim-grid">
            {{-- Panel Kiri: Kontrol Pilihan Interaktif --}}
            <div class="tuition-controls-card">
                
                {{-- 1. Pilihan Jenjang --}}
                <div class="sim-control-group">
                    <label class="sim-control-label">
                        <span class="step-num">1</span>
                        <span>Pilih Jenjang Pendidikan:</span>
                    </label>
                    <div class="sim-btn-group" role="radiogroup" aria-label="Jenjang Pendidikan">
                        <button type="button" class="sim-toggle-btn active" data-jenjang="sd">
                            <span class="btn-icon-sub" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </span>
                            <span class="btn-text-main">SD Tahfizh</span>
                            <span class="btn-badge-sub">6 Tahun</span>
                        </button>
                        <button type="button" class="sim-toggle-btn" data-jenjang="smp">
                            <span class="btn-icon-sub" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                            </span>
                            <span class="btn-text-main">SMP Tahfizh</span>
                            <span class="btn-badge-sub">3 Tahun</span>
                        </button>
                        <button type="button" class="sim-toggle-btn" data-jenjang="smk">
                            <span class="btn-icon-sub" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                            </span>
                            <span class="btn-text-main">SMK Vokasi</span>
                            <span class="btn-badge-sub">RPL/TKJ/DKV</span>
                        </button>
                    </div>
                </div>

                {{-- 2. Tipe Program / Format Belajar --}}
                <div class="sim-control-group">
                    <label class="sim-control-label">
                        <span class="step-num">2</span>
                        <span>Tipe Program Belajar:</span>
                    </label>
                    <div class="sim-program-group">
                        <label class="sim-program-option active" id="optFullday">
                            <input type="radio" name="program_type" value="fullday" checked>
                            <div class="sim-program-info">
                                <strong class="program-title">Full Day School</strong>
                                <span class="program-desc">Kegiatan 07.30 – 15.30 WIB (Makan siang &amp; snack termasuk)</span>
                            </div>
                        </label>
                        <label class="sim-program-option" id="optBoarding">
                            <input type="radio" name="program_type" value="boarding">
                            <div class="sim-program-info">
                                <strong class="program-title">Islamic Boarding School (Asrama)</strong>
                                <span class="program-desc">Hunian ber-AC, makan 3x sehari, laundry, &amp; pendampingan 24 jam</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- 3. Jalur Beasiswa & Prestasi --}}
                <div class="sim-control-group">
                    <label class="sim-control-label">
                        <span class="step-num">3</span>
                        <span>Jalur Pendaftaran &amp; Beasiswa:</span>
                    </label>
                    <div class="sim-select-wrap">
                        <select id="simJalurSelect" class="sim-select-field">
                            <option value="reguler" selected>Jalur Reguler (Standar Mandiri)</option>
                            <option value="tahfizh_30">Beasiswa Tahfizh 30 Juz (Bebas Biaya 100% SPP &amp; Pangkal)</option>
                            <option value="tahfizh_10">Beasiswa Tahfizh 10–20 Juz (Potongan 50% Uang Pangkal &amp; SPP)</option>
                            <option value="prestasi">Beasiswa Prestasi Akademik/Sains/LKS (Potongan 30% Uang Pangkal)</option>
                            <option value="afirmasi">Jalur Afirmasi Yatim &amp; Dhuafa (Bantuan Penuh Yayasan)</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- Panel Kanan: Rincian Estimasi & Total --}}
            <div class="tuition-summary-card">
                <div class="summary-card-header">
                    <span class="summary-badge">Estimasi Transparan</span>
                    <h3 class="summary-title" id="summaryTargetLabel">Paket SD Tahfizh — Full Day School</h3>
                </div>

                <div class="summary-breakdown-list">
                    <div class="summary-row">
                        <span class="summary-row-label">Biaya Formulir &amp; Pendaftaran</span>
                        <span class="summary-row-val" id="valFormulir">Rp 250.000</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-row-label">Uang Pangkal Sarana &amp; Pembangunan</span>
                        <span class="summary-row-val" id="valPangkal">Rp 6.500.000</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-row-label">Seragam Lengkap &amp; Modul Al-Qur'an</span>
                        <span class="summary-row-val" id="valSeragam">Rp 1.450.000</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-row-label">SPP Pendidikan Bulan Pertama</span>
                        <span class="summary-row-val" id="valSpp">Rp 550.000</span>
                    </div>
                    <div class="summary-row boarding-extra-row" id="rowBoardingExtra" style="display: none;">
                        <span class="summary-row-label">Biaya Asrama &amp; Konsumsi Bulan 1</span>
                        <span class="summary-row-val" id="valBoardingExtra">Rp 850.000</span>
                    </div>
                </div>

                {{-- Diskon Beasiswa --}}
                <div class="summary-discount-box" id="discountBox" style="display: none;">
                    <div class="discount-row">
                        <span class="discount-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span id="discountTitle">Potongan Beasiswa Tahfizh 30 Juz</span>
                        </span>
                        <span class="discount-val" id="discountAmount">- Rp 7.050.000</span>
                    </div>
                </div>

                {{-- Total Biaya Masuk Awal --}}
                <div class="summary-total-box">
                    <div>
                        <span class="total-label">Estimasi Total Masuk Awal:</span>
                        <div class="total-amount" id="totalAmount">Rp 8.750.000</div>
                        <span class="total-note">*Dapat diangsur selama proses daftar ulang</span>
                    </div>
                </div>

                <div class="summary-cta-actions">
                    <a href="{{ route('ppdb.create', ['jenjang' => 'sd']) }}" id="simCtaBtn" class="btn btn-primary sim-submit-btn">
                        <span>Daftar Jenjang Ini Sekarang &rarr;</span>
                    </a>
                    <a href="https://wa.me/6281270001920?text=Halo%20Admin%20PPDB%20At-Tamam,%20saya%20ingin%20konsultasi%20rincian%20biaya%20dan%20beasiswa" target="_blank" rel="noopener noreferrer" class="btn btn-outline sim-wa-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span>Konsultasi via WhatsApp</span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.tuition-simulator-wrapper {
    margin: 40px 0 60px;
}

.tuition-sim-container {
    background: linear-gradient(135deg, rgba(0, 33, 71, 0.85) 0%, rgba(0, 15, 30, 0.95) 100%);
    border: 1px solid rgba(0, 180, 216, 0.35);
    border-radius: 24px;
    padding: clamp(24px, 4vw, 42px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
}

[data-theme="light"] .tuition-sim-container {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-color: #cbd5e1;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.tuition-sim-header {
    text-align: center;
    max-width: 760px;
    margin: 0 auto 36px;
}

.tuition-sim-tag-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
    border-radius: 9999px;
    background: rgba(0, 180, 216, 0.15);
    border: 1px solid rgba(0, 180, 216, 0.4);
    color: #38bdf8;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 12px;
}

[data-theme="light"] .tuition-sim-tag-pill {
    background: #e0f2fe;
    border-color: #7dd3fc;
    color: #0284c7;
}

.tuition-sim-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 10px 0;
    line-height: 1.25;
}

[data-theme="light"] .tuition-sim-title {
    color: #0f172a;
}

.tuition-sim-subtitle {
    font-size: 0.95rem;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.6;
}

[data-theme="light"] .tuition-sim-subtitle {
    color: #64748b;
}

.tuition-sim-grid {
    display: grid;
    grid-template-columns: 1.15fr 1fr;
    gap: 28px;
    align-items: start;
}

@media (max-width: 900px) {
    .tuition-sim-grid {
        grid-template-columns: 1fr;
    }
}

.tuition-controls-card {
    background: rgba(0, 15, 30, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 24px;
}

[data-theme="light"] .tuition-controls-card {
    background: #f8fafc;
    border-color: #e2e8f0;
}

.sim-control-group {
    margin-bottom: 22px;
}

.sim-control-group:last-child {
    margin-bottom: 0;
}

.sim-control-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 12px;
}

[data-theme="light"] .sim-control-label {
    color: #0f172a;
}

.step-num {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #00B4D8;
    color: #ffffff;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
}

.sim-btn-group {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.sim-toggle-btn {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 12px;
    padding: 12px 8px;
    color: #cbd5e1;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 4px;
    transition: all 0.2s ease;
}

.sim-toggle-btn:hover {
    border-color: #38bdf8;
    background: rgba(0, 180, 216, 0.1);
    color: #ffffff;
}

.sim-toggle-btn.active {
    background: rgba(0, 180, 216, 0.25);
    border-color: #00B4D8;
    color: #ffffff;
    box-shadow: 0 0 14px rgba(0, 180, 216, 0.35);
}

[data-theme="light"] .sim-toggle-btn {
    background: #ffffff;
    border-color: #e2e8f0;
    color: #475569;
}

[data-theme="light"] .sim-toggle-btn.active {
    background: #e0f2fe;
    border-color: #0284c7;
    color: #0369a1;
}

.btn-icon-sub {
    font-size: 1.3rem;
}

.btn-text-main {
    font-size: 0.88rem;
    font-weight: 700;
}

.btn-badge-sub {
    font-size: 0.72rem;
    color: #94a3b8;
}

.sim-program-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sim-program-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    cursor: pointer;
    transition: all 0.2s ease;
}

.sim-program-option.active {
    background: rgba(0, 180, 216, 0.2);
    border-color: #00B4D8;
}

[data-theme="light"] .sim-program-option {
    background: #ffffff;
    border-color: #e2e8f0;
}

[data-theme="light"] .sim-program-option.active {
    background: #f0f9ff;
    border-color: #0284c7;
}

.sim-program-info {
    display: flex;
    flex-direction: column;
}

.program-title {
    font-size: 0.9rem;
    color: #ffffff;
}

[data-theme="light"] .program-title {
    color: #0f172a;
}

.program-desc {
    font-size: 0.78rem;
    color: #94a3b8;
}

.sim-select-wrap {
    position: relative;
}

.sim-select-field {
    width: 100%;
    padding: 12px 16px;
    border-radius: 12px;
    background: rgba(15, 23, 42, 0.85);
    border: 1px solid rgba(0, 180, 216, 0.35);
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    outline: none;
    cursor: pointer;
}

[data-theme="light"] .sim-select-field {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #0f172a;
}

.tuition-summary-card {
    background: rgba(0, 25, 50, 0.65);
    border: 1px solid rgba(0, 180, 216, 0.35);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    flex-direction: column;
}

[data-theme="light"] .tuition-summary-card {
    background: #ffffff;
    border-color: #e2e8f0;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.summary-card-header {
    margin-bottom: 18px;
}

.summary-badge {
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #38bdf8;
}

.summary-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #ffffff;
    margin: 4px 0 0;
}

[data-theme="light"] .summary-title {
    color: #0f172a;
}

.summary-breakdown-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

[data-theme="light"] .summary-breakdown-list {
    border-bottom-color: #f1f5f9;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.88rem;
}

.summary-row-label {
    color: #cbd5e1;
}

[data-theme="light"] .summary-row-label {
    color: #64748b;
}

.summary-row-val {
    font-weight: 700;
    color: #ffffff;
    font-family: monospace;
    font-size: 0.95rem;
}

[data-theme="light"] .summary-row-val {
    color: #0f172a;
}

.summary-discount-box {
    margin-top: 14px;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.35);
    border-radius: 10px;
    padding: 10px 14px;
}

.discount-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.discount-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #34d399;
}

.discount-val {
    font-weight: 800;
    color: #34d399;
    font-family: monospace;
    font-size: 0.95rem;
}

.summary-total-box {
    margin: 18px 0 20px;
    padding: 16px 20px;
    background: rgba(0, 180, 216, 0.12);
    border: 1px solid rgba(0, 180, 216, 0.3);
    border-radius: 14px;
}

[data-theme="light"] .summary-total-box {
    background: #f0f9ff;
    border-color: #bae6fd;
}

.total-label {
    font-size: 0.82rem;
    color: #94a3b8;
    text-transform: uppercase;
    font-weight: 700;
    display: block;
}

.total-amount {
    font-size: 1.8rem;
    font-weight: 900;
    color: #38bdf8;
    line-height: 1.2;
    margin: 4px 0 2px;
}

[data-theme="light"] .total-amount {
    color: #0284c7;
}

.total-note {
    font-size: 0.75rem;
    color: #94a3b8;
}

.summary-cta-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sim-submit-btn {
    width: 100%;
    justify-content: center;
    padding: 12px 18px;
    font-size: 0.92rem;
    font-weight: 800;
    border-radius: 12px;
}

.sim-wa-btn {
    width: 100%;
    justify-content: center;
    padding: 10px 18px;
    font-size: 0.85rem;
    border-radius: 12px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const config = {
        sd: {
            title: 'SD Tahfizh At-Tamam',
            formulir: 250000,
            pangkal: 6500000,
            seragam: 1450000,
            spp_fullday: 550000,
            spp_boarding: 1400000,
            canBoarding: false,
        },
        smp: {
            title: 'SMP Tahfizh At-Tamam',
            formulir: 300000,
            pangkal: 8500000,
            seragam: 1650000,
            spp_fullday: 650000,
            spp_boarding: 1650000,
            canBoarding: true,
        },
        smk: {
            title: 'SMK Vokasi (RPL/TKJ/DKV)',
            formulir: 300000,
            pangkal: 9500000,
            seragam: 1850000,
            spp_fullday: 700000,
            spp_boarding: 1750000,
            canBoarding: true,
        }
    };

    let selectedJenjang = 'sd';
    let selectedProgram = 'fullday';
    let selectedJalur = 'reguler';

    const jenjangButtons = document.querySelectorAll('.sim-toggle-btn');
    const programOptions = document.querySelectorAll('.sim-program-option');
    const optBoarding = document.getElementById('optBoarding');
    const jalurSelect = document.getElementById('simJalurSelect');
    const ctaBtn = document.getElementById('simCtaBtn');

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function calculate() {
        const c = config[selectedJenjang];
        
        // Handle boarding eligibility (SD only fullday)
        if (!c.canBoarding && selectedProgram === 'boarding') {
            selectedProgram = 'fullday';
            const fulldayInput = document.querySelector('input[name="program_type"][value="fullday"]');
            if (fulldayInput) fulldayInput.checked = true;
            programOptions.forEach(opt => opt.classList.toggle('active', opt.id === 'optFullday'));
        }

        if (optBoarding) {
            optBoarding.style.opacity = c.canBoarding ? '1' : '0.5';
            optBoarding.style.pointerEvents = c.canBoarding ? 'auto' : 'none';
        }

        // Base costs
        let formulir = c.formulir;
        let pangkal = c.pangkal;
        let seragam = c.seragam;
        let spp = (selectedProgram === 'boarding') ? c.spp_boarding : c.spp_fullday;

        // Calculate discount
        let discount = 0;
        let discountDesc = '';

        if (selectedJalur === 'tahfizh_30') {
            discount = pangkal + spp; // Free uang pangkal & 1st month SPP
            discountDesc = 'Beasiswa Tahfizh 30 Juz (Bebas Pangkal & SPP 100%)';
        } else if (selectedJalur === 'tahfizh_10') {
            discount = (pangkal * 0.5) + (spp * 0.5);
            discountDesc = 'Beasiswa Tahfizh 10–20 Juz (Potongan 50%)';
        } else if (selectedJalur === 'prestasi') {
            discount = (pangkal * 0.3);
            discountDesc = 'Beasiswa Prestasi Akademik/Sains (Potongan 30% Pangkal)';
        } else if (selectedJalur === 'afirmasi') {
            discount = pangkal + spp + (seragam * 0.5);
            discountDesc = 'Jalur Afirmasi Yatim & Dhuafa (Bantuan Yayasan)';
        }

        let totalAwal = Math.max(0, formulir + pangkal + seragam + spp - discount);

        // Update DOM
        const targetLabel = document.getElementById('summaryTargetLabel');
        if (targetLabel) {
            targetLabel.textContent = `${c.title} — ${selectedProgram === 'boarding' ? 'Boarding (Asrama)' : 'Full Day'}`;
        }

        document.getElementById('valFormulir').textContent = formatRupiah(formulir);
        document.getElementById('valPangkal').textContent = formatRupiah(pangkal);
        document.getElementById('valSeragam').textContent = formatRupiah(seragam);
        document.getElementById('valSpp').textContent = formatRupiah(spp);

        const discountBox = document.getElementById('discountBox');
        if (discount > 0) {
            discountBox.style.display = 'block';
            document.getElementById('discountTitle').textContent = discountDesc;
            document.getElementById('discountAmount').textContent = '- ' + formatRupiah(discount);
        } else {
            discountBox.style.display = 'none';
        }

        document.getElementById('totalAmount').textContent = formatRupiah(totalAwal);

        if (ctaBtn) {
            ctaBtn.href = `{{ route('ppdb.create') }}?jenjang=${selectedJenjang}`;
            ctaBtn.querySelector('span').textContent = `Daftar Jenjang ${selectedJenjang.toUpperCase()} Sekarang \u2192`;
        }
    }

    // Event listeners
    jenjangButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            jenjangButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedJenjang = this.dataset.jenjang;
            calculate();
        });
    });

    programOptions.forEach(opt => {
        opt.addEventListener('click', function() {
            programOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                selectedProgram = radio.value;
            }
            calculate();
        });
    });

    if (jalurSelect) {
        jalurSelect.addEventListener('change', function() {
            selectedJalur = this.value;
            calculate();
        });
    }

    // Initial run
    calculate();
});
</script>
