<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class SystemInfoComposer
{
    public function compose(View $view)
    {
        $view->with([
            'systemTime' => now()->format('Y-m-d H:i:s'),
            'laravelVersion' => app()->version(),
            'phpVersion' => PHP_VERSION,
            'environment' => app()->environment(),
        ]);
    }
}
