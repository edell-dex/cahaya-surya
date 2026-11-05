<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function guest_bisa_melihat_halaman_login()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** @test */
    public function superadmin_bisa_login_dan_diarahkan_ke_superadmin_dashboard()
    {
        $response = $this->post(route('login.post'), [
            'email'    => 'superadmin@cahayasurya.com',
            'password' => 'super@dmincahaya_',
        ]);

        $response->assertRedirect(route('superadmin.index'));
        $this->assertAuthenticated();
    }

    /** @test */
    public function admin_bisa_login_dan_diarahkan_ke_admin_pasien_dashboard()
    {
        $response = $this->post(route('login.post'), [
            'email'    => 'admin@cahayasurya.com',
            'password' => '@dmincahaya_',
        ]);

        $response->assertRedirect(route('admin.pasien.index'));
        $this->assertAuthenticated();
    }

    /** @test */
    public function superadmin_yang_sudah_login_diarahkan_ke_dashboard_saat_akses_login()
    {
        $user = User::where('email', 'superadmin@cahayasurya.com')->first();
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('superadmin.index'));
    }

    /** @test */
    public function admin_yang_sudah_login_diarahkan_ke_dashboard_saat_akses_login()
    {
        $user = User::where('email', 'admin@cahayasurya.com')->first();
        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('admin.pasien.index'));
    }

    /** @test */
    public function akses_home_mengarahkan_ke_dashboard_atau_login()
    {
        // Sebagai guest
        $resGuest = $this->get('/home');
        $resGuest->assertRedirect(route('login'));

        // Sebagai superadmin
        $superadmin = User::where('email', 'superadmin@cahayasurya.com')->first();
        $resSuper = $this->actingAs($superadmin)->get('/home');
        $resSuper->assertRedirect(route('superadmin.index'));

        // Sebagai admin
        $admin = User::where('email', 'admin@cahayasurya.com')->first();
        $resAdmin = $this->actingAs($admin)->get('/home');
        $resAdmin->assertRedirect(route('admin.pasien.index'));
    }
}
