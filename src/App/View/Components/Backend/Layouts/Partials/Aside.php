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
        $query = Navigation::query()
            ->whereNull('parent_id')
            ->where('is_active', false)
            ->where('subdomain', $subdomain);

        $navigations = $query->with(['children' => function ($q) {
            $q->where('is_active', false);
        }])->get();

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
