<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PpdbRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_present_on_http_responses(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_logout_endpoint_rejects_get_requests_to_prevent_logout_csrf(): void
    {
        $user = User::factory()->create();

        // GET request should be rejected (Method Not Allowed)
        $response = $this->actingAs($user)->get('/logout');
        $response->assertStatus(405);

        // User should still be authenticated
        $this->assertAuthenticatedAs($user);

        // POST request with valid session logs user out
        $postResponse = $this->post('/logout');
        $postResponse->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_unauthorized_visitor_cannot_view_ppdb_success_card_directly_without_session(): void
    {
        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'PPDB-2026-SECRET-01',
            'full_name' => 'Siswa Rahasia',
            'gender' => 'L',
            'birth_date' => '2012-05-15',
            'address' => 'Jl. Pribadi No. 99',
            'parent_name' => 'Orang Tua Rahasia',
            'parent_phone' => '081299998888',
            'jenjang' => 'sd',
            'status' => 'pending',
        ]);

        // Direct GET by an arbitrary visitor should be redirected to tracking with an alert
        $response = $this->get(route('ppdb.success', $reg->no_pendaftaran));
        $response->assertRedirect(route('ppdb.tracking'));
        $response->assertSessionHas('error');

        // Legitimate applicant with session can view it
        $authorizedResponse = $this->withSession(['submitted_ppdb_no' => $reg->no_pendaftaran])
            ->get(route('ppdb.success', $reg->no_pendaftaran));
        $authorizedResponse->assertOk();
        $authorizedResponse->assertSee($reg->full_name);

        // Admin can also view it
        $admin = User::factory()->create(['role' => 'admin_ppdb', 'is_active' => true]);
        $adminResponse = $this->actingAs($admin)->get(route('ppdb.success', $reg->no_pendaftaran));
        $adminResponse->assertOk();
    }

    public function test_ppdb_input_is_properly_sanitized_against_html_and_script_injection(): void
    {
        $payload = [
            'jenjang' => 'sd',
            'full_name' => '<script>alert("xss")</script>Muhammad Rizky<b></b>',
            'gender' => 'L',
            'birth_date' => '2015-08-17',
            'address' => '<p>Jl. Sudirman <b>No. 123</b></p>',
            'parent_name' => '<i>Bapak Hendra</i>',
            'parent_phone' => '08123456789<x>',
            'agreement' => '1',
        ];

        $response = $this->post('/ppdb/daftar', $payload);
        $response->assertSessionHasNoErrors();

        $saved = PpdbRegistration::latest()->first();
        $this->assertNotNull($saved);

        // Assert all HTML tags are completely stripped
        $this->assertEquals('alert("xss")Muhammad Rizky', $saved->full_name);
        $this->assertEquals('Jl. Sudirman No. 123', $saved->address);
        $this->assertEquals('Bapak Hendra', $saved->parent_name);
        $this->assertStringNotContainsString('<', $saved->parent_phone);
        $this->assertStringNotContainsString('>', $saved->parent_phone);
    }

    public function test_super_admin_cannot_deactivate_or_demote_themselves(): void
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Attempt self-deactivation and self-demotion
        $response = $this->actingAs($superAdmin)->put(route('admin.users.update', $superAdmin->id), [
            'name' => 'Super Admin Updated',
            'email' => $superAdmin->email,
            'role' => 'editor_akademik', // demotion attempt
            // 'is_active' omitted to attempt deactivation
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $superAdmin->refresh();
        $this->assertTrue($superAdmin->is_active, 'Super admin must remain active');
        $this->assertEquals('super_admin', $superAdmin->role, 'Super admin role cannot be self-demoted');
    }
}
