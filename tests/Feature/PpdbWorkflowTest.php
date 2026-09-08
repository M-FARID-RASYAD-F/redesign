<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PpdbWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminPpdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminPpdb = User::factory()->create([
            'name' => 'Admin PPDB',
            'email' => 'panitia@attamam.sch.id',
            'role' => 'admin_ppdb',
            'is_active' => true,
        ]);
    }

    public function test_full_ppdb_registration_submission_storage_and_admin_workflow(): void
    {
        Storage::fake('public');

        // 1. Publik mengisi form pendaftaran di /ppdb/daftar
        $fileKk = UploadedFile::fake()->create('kk.pdf', 500, 'application/pdf');
        $fileAkta = UploadedFile::fake()->create('akta.pdf', 500, 'application/pdf');
        $fileFoto = UploadedFile::fake()->image('pasfoto.jpg', 300, 400);
        $fileRapor = UploadedFile::fake()->create('rapor.pdf', 1000, 'application/pdf');

        $payload = [
            'full_name' => 'Ahmad Santoso',
            'gender' => 'L',
            'birth_date' => '2012-05-15',
            'address' => 'Jl. Pesantren No. 12, Bekasi',
            'parent_name' => 'Bambang Santoso',
            'parent_phone' => '081234567890',
            'doc_kk' => $fileKk,
            'doc_akta' => $fileAkta,
            'doc_foto' => $fileFoto,
            'doc_rapor' => $fileRapor,
            'agreement' => '1',
        ];

        $response = $this->post('/ppdb/daftar', $payload);

        // 2. Memastikan redirect ke halaman sukses
        $registration = PpdbRegistration::where('full_name', 'Ahmad Santoso')->first();
        $this->assertNotNull($registration, 'Data registrasi santri harus tersimpan di database.');
        $this->assertStringStartsWith('PPDB-', $registration->no_pendaftaran);
        $this->assertEquals('pending', $registration->status);

        $response->assertRedirect(route('ppdb.success', $registration->no_pendaftaran));

        // 3. Memastikan dokumen tersimpan di tabel ppdb_documents dan storage publik
        $this->assertCount(4, $registration->documents);

        foreach ($registration->documents as $doc) {
            $this->assertTrue(Storage::disk('public')->exists($doc->file_path));
            $this->assertEquals('belum_diverifikasi', $doc->verification_status);
        }

        // 4. Publik bisa melihat halaman bukti pendaftaran digital
        $this->get(route('ppdb.success', $registration->no_pendaftaran))
            ->assertOk()
            ->assertSee($registration->no_pendaftaran)
            ->assertSee('Ahmad Santoso');

        // 5. Publik bisa tracking status mandiri
        $this->post('/ppdb/cek-status', ['no_pendaftaran' => $registration->no_pendaftaran])
            ->assertOk()
            ->assertSee($registration->no_pendaftaran)
            ->assertSee('Menunggu verifikasi berkas');

        // 6. Admin PPDB login dan melihat pendaftar di daftar admin
        $this->actingAs($this->adminPpdb)
            ->get('/admin/ppdb')
            ->assertOk()
            ->assertSee($registration->no_pendaftaran)
            ->assertSee('Ahmad Santoso');

        // 7. Admin melihat berkas di halaman detail
        $this->actingAs($this->adminPpdb)
            ->get("/admin/ppdb/{$registration->id}")
            ->assertOk()
            ->assertSee('Ahmad Santoso')
            ->assertSee('KK')
            ->assertSee('AKTA LAHIR');

        // 8. Admin melakukan verifikasi & mengubah status kelulusan
        $this->actingAs($this->adminPpdb)
            ->post("/admin/ppdb/{$registration->id}/status", [
                'status' => 'diterima',
                'notes' => 'Selamat, berkas lengkap dan lolos seleksi berkas!',
            ])
            ->assertRedirect("/admin/ppdb/{$registration->id}");

        $registration->refresh();
        $this->assertEquals('diterima', $registration->status);
        $this->assertEquals('Selamat, berkas lengkap dan lolos seleksi berkas!', $registration->notes);

        // 9. Admin PPDB bisa ekspor CSV
        $this->actingAs($this->adminPpdb)
            ->get('/admin/ppdb/export')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
