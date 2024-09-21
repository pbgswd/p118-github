<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

trait CreatesApplication
{
    private function clearCache(): void
    {
        Artisan::call('cache:clear');
    }
}
