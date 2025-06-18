<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $display = true;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // update this from database | session
        $this->display = true;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if( $this->display ){
            return view('themeadmin::components.backend.layouts.partials.breadcrumb');
        }
        return false;
    }
}
