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

    public function getAdminSidebarNavigation($subdomain = null)
    {
        $query = Navigation::query()
            ->whereNull('parent_id')
            ->where('is_active', false);

        $navigations = $query->with(['children' => function ($q) {
            $q->where('is_active', false);
        }])->get();

        return $navigations;
    }
    public function getUserSidebarNavigation($subdomain)
    {
        // $query = Navigation::query()
        //     ->whereNull('parent_id')
        //     ->where('is_active', false)
        //     ->where('subdomain', $subdomain);

        // $navigations = $query->with(['children' => function ($q) {
        //     $q->where('is_active', false);
        // }])->get();
        $navigations = collect([
            (object)[
                'title' => 'Dashboard',
                'route' => 'admin.dashboard',
                'url' => route('admin.dashboard'),
                'nav_icon' => 'fas fa-home',
                'children' => collect([]),
            ]
        ]);

        return $navigations;
    }

    public function __construct()
    {
        if (Auth::guard()->name === 'admin') {
            $this->navigations = $this->getAdminSidebarNavigation();

            // $this->navigations = [
            //     'Dashboard' => ['name' => 'admin.dashboard', 'params' => []],
            //     'Announcements' => ['name' => 'admin.announcements.index', 'params' => []],
            //     'Ebook' => ['name' => 'admin.ebooks.index', 'params' => []],
            //     'Navigations' => ['name' => 'admin.navigations.index', 'params' => []],
            //     'Visitor Logs' => ['name' => 'admin.visitorlogs.index', 'params' => []],
            // ];
        } else {

            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;

            // $navigations = Navigation::where('subdomain', $subdomain)->get();


            $this->navigations = $this->getUserSidebarNavigation($subdomain);

            // dd($this->navigations);
            // $dynamicNavs = $navigations->mapWithKeys(function ($nav) use ($subdomain) {
            //     return [
            //         $nav->title => [
            //             'name' => $nav->route,
            //             'params' => ['subdomain' => $subdomain],
            //         ]
            //     ];
            // })->toArray();
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.partials.aside', ['navigations' => $this->navigations]);
    }
}
