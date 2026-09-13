<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PpdbMultiLevelTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminPpdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminPpdb = User::factory()->create([
            'name' => 'Admin PPDB',
            'email' => 'admin_ppdb@attamam.sch.id',
            'role' => 'admin_ppdb',
            'is_active' => true,
        ]);

        Major::create([
            'name' => 'Rekayasa Perangkat Lunak (RPL)',
            'slug' => 'rekayasa-perangkat-lunak-rpl',
            'description' => 'Program Keahlian Software Engineering',
            'icon' => '💻',
        ]);
    }

    public function test_portal_index_displays_sd_smp_smk_options(): void
    {
        $response = $this->get(route('ppdb.index'));

        $response->assertOk()
            ->assertSee('Sekolah Dasar (SD)')
            ->assertSee('Sekolah Menengah Pertama (SMP)')
            ->assertSee('Sekolah Menengah Kejuruan (SMK)')
            ->assertSee(route('ppdb.create', ['jenjang' => 'sd']))
            ->assertSee(route('ppdb.create', ['jenjang' => 'smp']))
            ->assertSee(route('ppdb.create', ['jenjang' => 'smk']));
    }

    public function test_visitor_can_register_for_sd(): void
    {
        $payload = [
            'jenjang' => 'sd',
            'full_name' => 'Fathia Azzahra',
            'gender' => 'P',
            'birth_date' => '2018-03-10',
            'address' => 'Jl. Anggrek No. 4, Jakarta',
            'parent_name' => 'Hendra Gunawan',
            'parent_phone' => '081234567801',
            'agreement' => '1',
        ];

        $response = $this->post(route('ppdb.store'), $payload);

        $reg = PpdbRegistration::where('full_name', 'Fathia Azzahra')->first();
        $this->assertNotNull($reg);
        $this->assertEquals('sd', $reg->jenjang);
        $this->assertNull($reg->major_choice);
        $this->assertEquals('Sekolah Dasar (SD)', $reg->jenjang_label);

        $response->assertRedirect(route('ppdb.success', $reg->no_pendaftaran));
    }

    public function test_visitor_can_register_for_smk_with_major(): void
    {
        $payload = [
            'jenjang' => 'smk',
            'major_choice' => 'Rekayasa Perangkat Lunak (RPL)',
            'full_name' => 'Rian Hidayat',
            'gender' => 'L',
            'birth_date' => '2010-08-20',
            'address' => 'Jl. Cempaka No. 88, Bekasi',
            'parent_name' => 'Agus Hidayat',
            'parent_phone' => '081234567802',
            'agreement' => '1',
        ];

        $response = $this->post(route('ppdb.store'), $payload);

        $reg = PpdbRegistration::where('full_name', 'Rian Hidayat')->first();
        $this->assertNotNull($reg);
        $this->assertEquals('smk', $reg->jenjang);
        $this->assertEquals('Rekayasa Perangkat Lunak (RPL)', $reg->major_choice);

        $response->assertRedirect(route('ppdb.success', $reg->no_pendaftaran));
    }

    public function test_admin_can_filter_registrations_by_jenjang(): void
    {
        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SD 1',
            'jenjang' => 'sd',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SMP 1',
            'jenjang' => 'smp',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SMK 1',
            'jenjang' => 'smk',
        ]);

        // Filter SD
        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['jenjang' => 'sd']))
            ->assertOk()
            ->assertSee('Siswa SD 1')
            ->assertDontSee('Siswa SMP 1')
            ->assertDontSee('Siswa SMK 1');

        // Filter SMP
        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['jenjang' => 'smp']))
            ->assertOk()
            ->assertSee('Siswa SMP 1')
            ->assertDontSee('Siswa SD 1')
            ->assertDontSee('Siswa SMK 1');

        // Filter SMK
        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['jenjang' => 'smk']))
            ->assertOk()
            ->assertSee('Siswa SMK 1')
            ->assertDontSee('Siswa SD 1')
            ->assertDontSee('Siswa SMP 1');
    }

    public function test_admin_can_update_jenjang_and_status(): void
    {
        $reg = PpdbRegistration::factory()->create([
            'jenjang' => 'sd',
            'status' => 'pending',
        ]);

        $this->actingAs($this->adminPpdb)
            ->post(route('admin.ppdb.status', $reg->id), [
                'status' => 'diverifikasi',
                'jenjang' => 'smp',
                'notes' => 'Dialihkan ke jenjang SMP sesuai hasil asesmen.',
            ])
            ->assertRedirect(route('admin.ppdb.show', $reg->id));

        $reg->refresh();
        $this->assertEquals('diverifikasi', $reg->status);
        $this->assertEquals('smp', $reg->jenjang);
    }

    public function test_admin_can_filter_registrations_by_status(): void
    {
        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa Pending 1',
            'status' => 'pending',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa Diterima 1',
            'status' => 'diterima',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa Ditolak 1',
            'status' => 'ditolak',
        ]);

        // Filter Pending
        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['status' => 'pending']))
            ->assertOk()
            ->assertSee('Siswa Pending 1')
            ->assertDontSee('Siswa Diterima 1')
            ->assertDontSee('Siswa Ditolak 1');

        // Filter Diterima
        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['status' => 'diterima']))
            ->assertOk()
            ->assertSee('Siswa Diterima 1')
            ->assertDontSee('Siswa Pending 1')
            ->assertDontSee('Siswa Ditolak 1');
    }

    public function test_admin_can_filter_registrations_by_jenjang_and_status(): void
    {
        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SD Pending',
            'jenjang' => 'sd',
            'status' => 'pending',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SD Diterima',
            'jenjang' => 'sd',
            'status' => 'diterima',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa SMP Diterima',
            'jenjang' => 'smp',
            'status' => 'diterima',
        ]);

        $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.index', ['jenjang' => 'sd', 'status' => 'diterima']))
            ->assertOk()
            ->assertSee('Siswa SD Diterima')
            ->assertDontSee('Siswa SD Pending')
            ->assertDontSee('Siswa SMP Diterima');
    }

    public function test_admin_can_export_csv_with_status_filter(): void
    {
        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa CSV Pending',
            'status' => 'pending',
        ]);

        PpdbRegistration::factory()->create([
            'full_name' => 'Siswa CSV Diterima',
            'status' => 'diterima',
        ]);

        $response = $this->actingAs($this->adminPpdb)
            ->get(route('admin.ppdb.export', ['status' => 'diterima']));

        $response->assertOk();
        $this->assertStringContainsString('rekap-ppdb-diterima', $response->headers->get('content-disposition'));
    }
}
