<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AsideMobile extends Component
{
    public $navigations = null;

    // public function __construct($navigations)
    // {
    //     $this->navigations = $navigations;
    // }

    public function __construct()
    {
        if (Auth::guard()->name === 'admin') {
            $this->navigations = [
                'Dashboard' => ['name' => 'admin.dashboard', 'params' => []],
                'Announcements' => ['name' => 'admin.announcements.index', 'params' => []],
            ];
        } else {
            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;
            $this->navigations = [
                'Dashboard' => ['name' => 'user.dashboard', 'params' => ['subdomain' => $subdomain]],
                'Ebooks' => ['name' => 'ebooks.index', 'params' => ['subdomain' => $subdomain]],
            ];
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.aside-mobile', ['navigations' => $this->navigations]);
    }
}
