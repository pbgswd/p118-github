<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{

    private function clearCache(): void
    {
        Artisan::call('cache:clear');
    }
}
