<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Aside extends Component
{
    public $navigations = null;

    // public function __construct($navigations)
    // {
    //     $this->navigations = $navigations;
    // }

    public function __construct()
    {
        if (Auth::guard()->name === 'admin') {
            $this->navigations = ['Announcements' => 'admin.announcements.index'];
        } else {
            $this->navigations = ['Ebooks' => 'ebooks.index'];
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.aside', ['navigations' => $this->navigations]);
    }
}
