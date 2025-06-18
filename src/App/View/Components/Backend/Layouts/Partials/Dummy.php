<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use Illuminate\View\Component;

class Dummy extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.dummy');
    }
}
