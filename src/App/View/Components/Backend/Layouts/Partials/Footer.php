<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use Exception;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Footer extends Component
{
    public $companyName = null;

    public function __construct($companyName)
    {
        $this->companyName = $companyName;
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.footer', ['companyName'=>$this->companyName]);
    }
}
