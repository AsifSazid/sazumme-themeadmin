<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use App\Models\Navigation;
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
            $this->navigations = [
                'Dashboard' => ['name' => 'admin.dashboard', 'params' => []],
                'Announcements' => ['name' => 'admin.announcements.index', 'params' => []],
                'Navigations' => ['name' => 'admin.navigations.index', 'params' => []],
                'Visitor Logs' => ['name' => 'admin.visitorlogs.index', 'params' => []],
            ];
        } else {
            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;

            $navigations = Navigation::where('subdomain', $subdomain)->get();

            $this->navigations = [
                'Dashboard' => ['name' => 'user.dashboard', 'params' => ['subdomain' => $subdomain]],
            ];

            $dynamicNavs = $navigations->mapWithKeys(function ($nav) use ($subdomain) {
                return [
                    $nav->title => [
                        'name' => $nav->route,
                        'params' => ['subdomain' => $subdomain],
                    ]
                ];
            })->toArray();

            $this->navigations = array_merge($this->navigations, $dynamicNavs);
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.aside', ['navigations' => $this->navigations]);
    }
}
