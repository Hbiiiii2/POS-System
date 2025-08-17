<header class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700/60 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Header: Left side -->
            <div class="flex items-center space-x-4">
                
                <!-- Hamburger button -->
                <button
                    class="lg:hidden p-2 rounded-lg text-gray-600 hover:text-violet-600 hover:bg-violet-50 dark:text-gray-400 dark:hover:text-violet-400 dark:hover:bg-violet-900/20 transition-all duration-200"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="4" y="5" width="16" height="2" />
                        <rect x="4" y="11" width="16" height="2" />
                        <rect x="4" y="17" width="16" height="2" />
                    </svg>
                </button>

                <!-- Page Title -->
                <div class="hidden sm:block">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        @if(Route::is('dashboard'))
                            Dashboard
                        @elseif(Route::is('pos.*'))
                            Point of Sale
                        @elseif(Route::is('categories.*'))
                            Categories
                        @elseif(Route::is('products.*'))
                            Products
                        @elseif(Route::is('reports.*'))
                            Reports
                        @else
                            {{ ucfirst(Request::segment(1) ?? 'Dashboard') }}
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if(Route::is('dashboard'))
                            Overview & Analytics
                        @elseif(Route::is('pos.*'))
                            Manage sales and transactions
                        @elseif(Route::is('categories.*'))
                            Organize your products
                        @elseif(Route::is('products.*'))
                            Manage inventory
                        @elseif(Route::is('reports.*'))
                            Sales insights & analytics
                        @else
                            Welcome back, {{ auth()->user()->name }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">

                <!-- Search Button with Modal -->
                <x-modal-search />

                <!-- Notifications button -->
                <x-dropdown-notifications align="right" />

                <!-- Info button -->
                <x-dropdown-help align="right" />

                <!-- Dark mode toggle -->
                <x-theme-toggle />                

                <!-- Divider -->
                <div class="w-px h-8 bg-gradient-to-b from-transparent via-gray-300 dark:via-gray-600 to-transparent"></div>

                <!-- User button -->
                <x-dropdown-profile align="right" />

            </div>

        </div>
    </div>
</header>