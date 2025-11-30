<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}

    // In your Controller or AppServiceProvider
View::composer('components.admin-sidebar', function ($view) {
    $view->with([
        // ... your existing data ...
        'unreadNotificationsCount' => auth()->check() ? Auth::user()->unreadNotifications->count() : 0,
    ]);
});
