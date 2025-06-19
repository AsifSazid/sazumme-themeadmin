<?php

namespace Sazumme\Themeadmin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class themeadminServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $host = request()->getHost();
            $parts = explode('.', $host);
            $subdomain = count($parts) > 2 ? $parts[0] : null;

            $companyNames = [
                'publication' => 'SazVerse Publication',
                // 'sub_two' => 'Company Two',
                // 'sub_three' => 'Company Three',
            ];

            $companyName = $companyNames[$subdomain] ?? 'SazUmme Technology';

            $view->with('companyName', $companyName);
            $view->with('subdomain', $subdomain);
        });


        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'themeadmin');

        $this->publishes([
            __DIR__ . '/../publishable/assets' => public_path('vendor/themeadmin'),
        ], 'public');



        $this->layouts();
        $this->libs();
        $this->partials();
    }

    public function layouts()
    {
        \Illuminate\Support\Facades\Blade::component('sb-admin-master', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Master::class);
    }

    private function libs()
    {
        \Illuminate\Support\Facades\Blade::component('sb-admin-style', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Libs\Style::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-js', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Libs\Js::class);
    }

    private function partials()
    {
        \Illuminate\Support\Facades\Blade::component('sb-admin-meta', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Meta::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-dummy', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Dummy::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-breadcrumb', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Breadcrumb::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-title', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Title::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-favicon', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Favicon::class);


        \Illuminate\Support\Facades\Blade::component('sb-admin-aside', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Aside::class);
        \Illuminate\Support\Facades\Blade::component('sb-admin-footer', \Sazumme\Themeadmin\App\View\Components\Backend\Layouts\Partials\Footer::class);
    }
}
