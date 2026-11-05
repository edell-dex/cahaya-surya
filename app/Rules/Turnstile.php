<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Turnstile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Bypass validation during automated tests
        if (app()->environment('testing')) {
            return;
        }

        $secret = config('services.turnstile.secret_key');

        if (empty($secret)) {
            Log::warning('Turnstile secret key is not configured.');
            return;
        }

        if (empty($value)) {
            $fail('Verifikasi keamanan Cloudflare Turnstile wajib dilengkapi.');
            return;
        }

        try {
            $response = Http::asForm()->timeout(10)->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret'   => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!($result['success'] ?? false)) {
                $fail('Verifikasi keamanan Cloudflare Turnstile tidak valid atau telah kedaluwarsa. Silakan coba lagi.');
            }
        } catch (\Throwable $e) {
            Log::error('Cloudflare Turnstile verification error: ' . $e->getMessage());
            $fail('Gagal menghubungi layanan Cloudflare Turnstile. Silakan coba sesaat lagi.');
        }
    }
}
