@php use Illuminate\Support\Str; @endphp
<div class="border-b md:hidden dark:border-primary-darker" x-show="isMobileMainMenuOpen"
    @click.away="isMobileMainMenuOpen = false">
    <nav aria-label="Main" class="px-2 py-4 space-y-2">
        @foreach ($navigations as $navTitle => $navLink)
            @php
                $url = is_array($navLink) ? route($navLink['name'], $navLink['params']) : $navLink;

                $isActive = is_array($navLink) ? request()->routeIs($navLink['name']) : request()->url() === $navLink;
            @endphp

            <a href="{{ $url }}"
                class="{{ $isActive ? 'bg-primary-100 dark:bg-primary' : '' }} flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                role="button" aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                <span aria-hidden="true">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </span>
                <span class="ml-2 text-sm"> {{ Str::title($navTitle) }} </span>
            </a>
        @endforeach
    </nav>
</div>
