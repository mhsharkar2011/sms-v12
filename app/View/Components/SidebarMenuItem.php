<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarMenuItem extends Component
{
    public $item;
    public $active;
    public $compact;

    public function __construct($item, $active = false, $compact = false)
    {
        $this->item = $item;
        $this->active = $active;
        $this->compact = $compact;
    }

    public function render()
    {
        return view('components.sidebar-menu-item');
    }
}
