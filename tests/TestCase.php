<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Vite; // Pastikan ini ada

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Vite::useHotFile(storage_path('vite.hot'))
            ->useBuildDirectory('build')
            ->withEntryPoints([
                'resources/sass/app.scss', // <-- SESUAIKAN DENGAN vite.config.js ANDA
                'resources/js/app.js'    // <-- SESUAIKAN DENGAN vite.config.js ANDA
            ]);
    }
}