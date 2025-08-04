<aside class="flex-shrink-0 hidden w-64 bg-white border-r dark:border-primary-darker dark:bg-darker md:block">
    <div class="flex flex-col h-full">
        <nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto">
            @foreach ($navigations as $nav)
                @if ($nav->children->count())
                    <!-- Accordion Parent -->
                    <div x-data="{ open: false }" class="mb-2">
                        <a href="#" @click.prevent="open = !open"
                            class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                            :class="{ 'bg-primary-100 dark:bg-primary': open }" role="button" aria-haspopup="true"
                            :aria-expanded="open ? 'true' : 'false'">

                            <!-- Icon -->
                            @if ($nav->nav_icon)
                                <i class="{{ $nav->nav_icon }} w-5 h-5"></i>
                            @else
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            @endif

                            <!-- Title -->
                            <span class="ml-2 text-sm">{{ $nav->title }}</span>

                            <!-- Chevron -->
                            <span class="ml-auto">
                                <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </a>

                        <!-- Accordion Children -->
                        <div x-show="open" x-transition class="mt-2 space-y-2 px-7" role="menu"
                            aria-label="{{ $nav->title }}">
                            @foreach ($nav->children as $child)
                                <a href="{{ route($child->route) }}" role="menuitem"
                                    class="block p-2 text-sm rounded-md transition-colors duration-200
                                {{ request()->routeIs($child->route)
                                    ? 'text-gray-700 dark:text-light bg-primary-50 dark:bg-primary'
                                    : 'text-gray-400 dark:text-gray-400 hover:text-gray-700 dark:hover:text-light' }}">
                                    {{ $child->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Single Item (no children) -->
                    @if (Route::has($nav->route))
                        <a href="{{ route($nav->route) }}"
                            class="flex items-center p-2 text-sm text-gray-500 rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary
                                {{ request()->routeIs($nav->route) ? 'bg-primary-100 dark:bg-primary font-semibold' : '' }}">
                            @if ($nav->nav_icon)
                                <i class="{{ $nav->nav_icon }} w-5 h-5"></i>
                            @endif
                            <span class="ml-2">{{ $nav->title }}</span>
                        </a>
                    @else
                        <span class="flex items-center p-2 text-sm text-red-500 bg-red-50 rounded-md">
                            ⚠️ Invalid Route: <code>{{ $nav->title }}</code>
                        </span>
                    @endif
                @endif
            @endforeach


        </nav>
    </div>
</aside>
