<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminSidebar extends Component
{
    public $compact;
    public $sidebarData;
    public $quickStats;
    public $activeStates;
    public $activeRoute;

    public function __construct($compact = false)
    {
        $this->compact = $compact;

        // Data will be injected by the View Composer
        $this->sidebarData = [];
        $this->quickStats = [];
        $this->activeStates = [];
        $this->activeRoute = '';
    }

    public function render()
    {
        return view('components.admin-sidebar');
    }
}
