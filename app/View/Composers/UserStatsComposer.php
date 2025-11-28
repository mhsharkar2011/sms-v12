<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class UserStatsComposer
{
    public function compose(View $view)
    {
        $stats = Cache::remember('user_stats', 300, function () {
            return [
                'total_users' => User::count(),
                'active_users' => User::where('status', 'active')->count(),
                'new_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
                'verification_rate' => $this->calculateVerificationRate(),
            ];
        });

        $view->with('userStats', $stats);
    }

    protected function calculateVerificationRate()
    {
        $total = User::count();
        $verified = User::whereNotNull('email_verified_at')->count();

        return $total > 0 ? round(($verified / $total) * 100, 1) : 0;
    }
}
