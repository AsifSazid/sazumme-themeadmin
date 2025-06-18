<?php

namespace SazUmme\Themeadmin\App\View\Components\Backend\Layouts;

use Illuminate\View\Component;

class Master extends Component
{

    public function __construct()
    {

    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.master');
    }
}
