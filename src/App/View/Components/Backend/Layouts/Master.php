<?php

namespace SazUmme\Themeadmin\App\View\Components\Backend\Layouts;

use App\Http\Controllers\DomainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Master extends Component
{
    public $profileRoute = null;

    public function __construct()
    {
        if (Auth::guard()->name === 'admin') {
            $this->profileRoute = route('admin.profile.edit');
        } else {
            $domainController = new DomainController;
            $subdomain = $domainController->getSubdomain();
            $this->profileRoute = route('user.profile.edit', ['subdomain' => $subdomain]);
        }
    }

    public function render()
    {
        return view('themeadmin::components.backend.layouts.master', ['profileRoute' => $this->profileRoute]);
    }
}
