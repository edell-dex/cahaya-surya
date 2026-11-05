<?php

namespace Tests\Feature;

use App\Rules\Turnstile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TurnstileIntegrationTest extends TestCase
{
    /** @test */
    public function form_pendaftaran_sekolah_menampilkan_turnstile()
    {
        $response = $this->get(route('pendaftaran.sekolah'));
        $response->assertStatus(200);
        $response->assertSee('challenges.cloudflare.com/turnstile/v0/api.js');
        $response->assertSee(config('services.turnstile.site_key'));
    }

    /** @test */
    public function form_pendaftaran_perusahaan_menampilkan_turnstile()
    {
        $response = $this->get(route('pendaftaran.perusahaan'));
        $response->assertStatus(200);
        $response->assertSee('challenges.cloudflare.com/turnstile/v0/api.js');
        $response->assertSee(config('services.turnstile.site_key'));
    }

    /** @test */
    public function turnstile_rule_lolos_jika_verifikasi_berhasil()
    {
        // Force non-testing app environment simulation for this rule test
        $this->app['env'] = 'production';

        Http::fake([
            'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $validator = Validator::make([
            'cf-turnstile-response' => 'dummy_token_valid',
        ], [
            'cf-turnstile-response' => ['required', new Turnstile],
        ]);

        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function turnstile_rule_gagal_jika_verifikasi_cloudflare_tidak_valid()
    {
        // Force non-testing app environment simulation for this rule test
        $this->app['env'] = 'production';

        Http::fake([
            'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ], 200),
        ]);

        $validator = Validator::make([
            'cf-turnstile-response' => 'dummy_token_invalid',
        ], [
            'cf-turnstile-response' => ['required', new Turnstile],
        ]);

        $this->assertTrue($validator->fails());
        $this->assertStringContainsString('Cloudflare', $validator->errors()->first('cf-turnstile-response'));
    }
}
