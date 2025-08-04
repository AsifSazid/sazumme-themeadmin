<?php

namespace Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials;

use App\Models\Navigation;
use App\Models\UserWing;
use App\Models\Wing;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Aside extends Component
{
    public $navigations = null;


    public function getAdminSidebarNavigation($subdomain = null)
    {
        $query = Navigation::query()
            ->whereNull('parent_id')
            ->where('is_active', true);

        $navigations = $query->with(['children' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        // dd($navigations);

        // $navigations = collect([
        //     (object)[
        //         'title' => 'Go To Welcome Page',
        //         'route' => 'welcome',
        //         'url' => route('welcome'),
        //         'nav_icon' => 'fas fa-home',
        //         'children' => collect([]),
        //     ],
        // ]);

        return $navigations ;
    }
    public function getUserSidebarNavigation($subdomain)
    {
        $user = Auth::user()->uuid;
        $wing = Wing::where('subdomain', $subdomain)->first()->uuid;
        $hasPermission = UserWing::where('user_uuid', $user)
            ->where('wing_uuid', $wing)
            ->exists();

        if ($hasPermission) {
            $query = Navigation::query()
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->where('subdomain', $subdomain);

            $navigations = $query->with(['children' => function ($q) {
                $q->where('is_active', true);
            }])->get();
        } else {
            $navigations = collect([
                (object)[
                    'title' => 'Go To Welcome Page',
                    'route' => $subdomain . '.landing',
                    'url' => route($subdomain . '.landing'),
                    'nav_icon' => 'fas fa-home',
                    'children' => collect([]),
                ],
            ]);
        }

        return $navigations;
    }

    public function __construct()
    {
        if (Auth::guard()->name === 'admin') {
            $this->navigations = $this->getAdminSidebarNavigation();
        } else {

            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;

            $this->navigations = $this->getUserSidebarNavigation($subdomain);
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.aside', ['navigations' => $this->navigations]);
    }
}
