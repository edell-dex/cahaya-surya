<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fallback autoloader untuk DomPDF jika autoload composer di hosting belum di-update
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            spl_autoload_register(function ($class) {
                $map = [
                    'Barryvdh\\DomPDF\\' => base_path('vendor/barryvdh/laravel-dompdf/src/'),
                    'Dompdf\\'           => base_path('vendor/dompdf/dompdf/src/'),
                    'FontLib\\'          => base_path('vendor/dompdf/php-font-lib/src/FontLib/'),
                    'Svg\\'              => base_path('vendor/dompdf/php-svg-lib/src/Svg/'),
                    'Masterminds\\'      => base_path('vendor/masterminds/html5/src/'),
                    'Sabberworm\\CSS\\'  => base_path('vendor/sabberworm/php-css-parser/src/'),
                ];

                foreach ($map as $prefix => $baseDir) {
                    $len = strlen($prefix);
                    if (strncmp($prefix, $class, $len) === 0) {
                        $relativeClass = substr($class, $len);
                        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
                        if (file_exists($file)) {
                            require_once $file;
                            return true;
                        }
                    }
                }
                return false;
            });

            if (class_exists(\Barryvdh\DomPDF\ServiceProvider::class)) {
                $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
