<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

abstract class Controller
{

}

    // In your Controller or AppServiceProvider
View::composer('components.admin-sidebar', function ($view) {
    $view->with([
        // ... your existing data ...
        'unreadNotificationsCount' => auth()->check() ? auth()->user()->unreadNotifications->count() : 0,
    ]);
});
