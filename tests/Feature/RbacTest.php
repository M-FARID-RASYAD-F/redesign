<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\Major;
use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminCms;
    protected User $adminPpdb;
    protected User $editorAkademik;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@attamam.sch.id',
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->adminCms = User::factory()->create([
            'name' => 'Admin CMS',
            'email' => 'cms@attamam.sch.id',
            'role' => 'admin_cms',
            'is_active' => true,
        ]);

        $this->adminPpdb = User::factory()->create([
            'name' => 'Admin PPDB',
            'email' => 'ppdb@attamam.sch.id',
            'role' => 'admin_ppdb',
            'is_active' => true,
        ]);

        $this->editorAkademik = User::factory()->create([
            'name' => 'Editor Akademik',
            'email' => 'akademik@attamam.sch.id',
            'role' => 'editor_akademik',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_super_admin_can_access_all_dashboards_and_users(): void
    {
        $this->actingAs($this->superAdmin)
            ->get('/admin/dashboard')
            ->assertOk();

        $this->actingAs($this->superAdmin)
            ->get('/admin/cms/dashboard')
            ->assertOk();

        $this->actingAs($this->superAdmin)
            ->get('/admin/ppdb/dashboard')
            ->assertOk();

        $this->actingAs($this->superAdmin)
            ->get('/admin/akademik/dashboard')
            ->assertOk();

        $this->actingAs($this->superAdmin)
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_admin_cms_can_access_cms_dashboard_but_forbidden_from_user_management(): void
    {
        $this->actingAs($this->adminCms)
            ->get('/admin/cms/dashboard')
            ->assertOk();

        $this->actingAs($this->adminCms)
            ->get('/admin/users')
            ->assertForbidden();

        $this->actingAs($this->adminCms)
            ->get('/admin/ppdb/dashboard')
            ->assertForbidden();
    }

    public function test_admin_ppdb_can_access_ppdb_dashboard_but_forbidden_from_user_management(): void
    {
        $this->actingAs($this->adminPpdb)
            ->get('/admin/ppdb/dashboard')
            ->assertOk();

        $this->actingAs($this->adminPpdb)
            ->get('/admin/users')
            ->assertForbidden();

        $this->actingAs($this->adminPpdb)
            ->get('/admin/cms/dashboard')
            ->assertForbidden();
    }

    public function test_editor_akademik_can_access_akademik_dashboard_but_forbidden_from_others(): void
    {
        $this->actingAs($this->editorAkademik)
            ->get('/admin/akademik/dashboard')
            ->assertOk();

        $this->actingAs($this->editorAkademik)
            ->get('/admin/users')
            ->assertForbidden();

        $this->actingAs($this->editorAkademik)
            ->get('/admin/cms/dashboard')
            ->assertForbidden();

        $this->actingAs($this->editorAkademik)
            ->get('/admin/ppdb/dashboard')
            ->assertForbidden();
    }

    public function test_admin_ppdb_cannot_delete_ppdb_record(): void
    {
        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'REG-TEST-001',
            'full_name' => 'Siswa Uji',
            'gender' => 'L',
            'birth_date' => '2010-05-15',
            'address' => 'Jl. Test No. 1',
            'parent_name' => 'Wali Uji',
            'parent_phone' => '081234567890',
            'major_choice' => 'rpl',
            'status' => 'pending',
        ]);

        $this->actingAs($this->adminPpdb)
            ->delete("/admin/ppdb/{$reg->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('ppdb_registrations', [
            'id' => $reg->id,
        ]);
    }

    public function test_super_admin_can_delete_ppdb_record(): void
    {
        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'REG-TEST-002',
            'full_name' => 'Siswa Uji Super',
            'gender' => 'L',
            'birth_date' => '2010-05-15',
            'address' => 'Jl. Test No. 2',
            'parent_name' => 'Wali Uji',
            'parent_phone' => '081234567890',
            'major_choice' => 'tahfizh',
            'status' => 'pending',
        ]);

        $this->actingAs($this->superAdmin)
            ->delete("/admin/ppdb/{$reg->id}")
            ->assertRedirect(route('admin.ppdb.index'));

        $this->assertDatabaseMissing('ppdb_registrations', [
            'id' => $reg->id,
        ]);
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $inactive = User::factory()->create([
            'role' => 'admin_cms',
            'is_active' => false,
        ]);

        $this->actingAs($inactive)
            ->get('/admin/cms/dashboard')
            ->assertForbidden();
    }

    public function test_login_redirects_to_appropriate_role_dashboard(): void
    {
        // 1. Super Admin
        $response = $this->post('/login-process', [
            'email' => $this->superAdmin->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.dashboard'));
        $this->get('/logout');

        // 2. Admin CMS
        $response = $this->post('/login-process', [
            'email' => $this->adminCms->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.cms.dashboard'));
        $this->get('/logout');

        // 3. Admin PPDB
        $response = $this->post('/login-process', [
            'email' => $this->adminPpdb->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.ppdb.dashboard'));
        $this->get('/logout');

        // 4. Editor Akademik
        $response = $this->post('/login-process', [
            'email' => $this->editorAkademik->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('admin.akademik.dashboard'));
    }

    public function test_editor_akademik_can_create_teacher_but_admin_ppdb_cannot(): void
    {
        $this->actingAs($this->editorAkademik)
            ->get('/admin/teachers/create')
            ->assertOk();

        $this->actingAs($this->adminPpdb)
            ->get('/admin/teachers/create')
            ->assertForbidden();
    }

    public function test_admin_cms_can_create_news_but_editor_akademik_cannot(): void
    {
        $this->actingAs($this->adminCms)
            ->get('/admin/news/create')
            ->assertOk();

        $this->actingAs($this->editorAkademik)
            ->get('/admin/news/create')
            ->assertForbidden();
    }

    public function test_admin_ppdb_can_update_status_but_editor_akademik_cannot(): void
    {
        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'REG-TEST-003',
            'full_name' => 'Siswa Uji Status',
            'gender' => 'P',
            'birth_date' => '2010-06-20',
            'address' => 'Jl. Test No. 3',
            'parent_name' => 'Wali Uji',
            'parent_phone' => '081234567890',
            'major_choice' => 'rpl',
            'status' => 'pending',
        ]);

        // Editor Akademik blocked by route middleware
        $this->actingAs($this->editorAkademik)
            ->post("/admin/ppdb/{$reg->id}/status", ['status' => 'diverifikasi'])
            ->assertForbidden();

        // Admin PPDB allowed
        $this->actingAs($this->adminPpdb)
            ->post("/admin/ppdb/{$reg->id}/status", ['status' => 'diverifikasi'])
            ->assertRedirect(route('admin.ppdb.show', $reg->id));

        $this->assertDatabaseHas('ppdb_registrations', [
            'id' => $reg->id,
            'status' => 'diverifikasi',
        ]);
    }
}
