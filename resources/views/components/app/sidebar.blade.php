<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-gradient-to-b from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 p-4 transition-all duration-200 ease-in-out border-r border-gray-200 dark:border-gray-700"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-8 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400 transition-colors"
                @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block group" href="{{ route('dashboard') }}">
                <div
                    class="flex items-center space-x-3 p-2 rounded-xl bg-gradient-to-r from-violet-500 to-purple-600 shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <svg class="fill-white w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <path
                            d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                    </svg>
                    <span
                        class="text-white font-bold text-lg lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">POS</span>
                </div>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-6">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold pl-3 mb-4 tracking-wider">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Menu Utama</span>
                </h3>
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 @if (Route::is('dashboard')) {{ 'bg-gradient-to-r from-violet-500 to-purple-600 text-white shadow-lg' }}@else{{ 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif"
                            href="{{ route('dashboard') }}">
                            <div
                                class="flex items-center justify-center w-8 h-8 rounded-lg @if (Route::is('dashboard')) {{ 'bg-white/20' }}@else{{ 'bg-gray-100 dark:bg-gray-700 group-hover:bg-violet-100 dark:group-hover:bg-violet-900/20' }} @endif transition-all duration-200">
                                <svg class="w-5 h-5 @if (Route::is('dashboard')) {{ 'text-white' }}@else{{ 'text-gray-600 dark:text-gray-400 group-hover:text-violet-600 dark:group-hover:text-violet-400' }} @endif transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                            </div>
                            <span
                                class="ml-3 font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Dashboard</span>
                        </a>
                    </li>

                    <!-- POS System -->
                    <li x-data="{ open: {{ in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports']) ? 1 : 0 }} }">
                        <button @click="open = !open; sidebarExpanded = true"
                            class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 @if (in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports'])) {{ 'bg-gradient-to-r from-violet-500 to-purple-600 text-white shadow-lg' }}@else{{ 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif">
                            <div class="flex items-center">
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-lg @if (in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports'])) {{ 'bg-white/20' }}@else{{ 'bg-gray-100 dark:bg-gray-700 group-hover:bg-violet-100 dark:group-hover:bg-violet-900/20' }} @endif transition-all duration-200">
                                    <svg class="w-5 h-5 @if (in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports'])) {{ 'text-white' }}@else{{ 'text-gray-600 dark:text-gray-400 group-hover:text-violet-600 dark:group-hover:text-violet-400' }} @endif transition-colors duration-200"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span
                                    class="ml-3 font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">POS
                                    System</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 @if (in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports'])) {{ 'rotate-180' }} @endif"
                                :class="open ? 'rotate-180' : 'rotate-0'" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block mt-2">
                            <ul class="space-y-1 pl-8 @if (!in_array(Request::segment(1), ['pos', 'categories', 'products', 'reports'])) {{ 'hidden' }} @endif"
                                :class="open ? 'block!' : 'hidden'">


                                @if (auth()->user()->role === 'kasir')
                                    <li>
                                        <a class="group flex items-center px-3 py-2 rounded-lg transition-all duration-200 @if (Route::is('pos.index')) {{ 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' }}@else{{ 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif"
                                            href="{{ route('pos.index') }}">
                                            <div
                                                class="w-2 h-2 rounded-full @if (Route::is('pos.index')) {{ 'bg-violet-500' }}@else{{ 'bg-gray-400 group-hover:bg-violet-400' }} @endif transition-colors duration-200">
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">POS</span>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()->role === 'admin')
                                    <li>
                                        <a class="group flex items-center px-3 py-2 rounded-lg transition-all duration-200 @if (Route::is('categories.*')) {{ 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' }}@else{{ 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif"
                                            href="{{ route('categories.index') }}">
                                            <div
                                                class="w-2 h-2 rounded-full @if (Route::is('categories.*')) {{ 'bg-violet-500' }}@else{{ 'bg-gray-400 group-hover:bg-violet-400' }} @endif transition-colors duration-200">
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Categories</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="group flex items-center px-3 py-2 rounded-lg transition-all duration-200 @if (Route::is('products.*')) {{ 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' }}@else{{ 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif"
                                            href="{{ route('products.index') }}">
                                            <div
                                                class="w-2 h-2 rounded-full @if (Route::is('products.*')) {{ 'bg-violet-500' }}@else{{ 'bg-gray-400 group-hover:bg-violet-400' }} @endif transition-colors duration-200">
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Products</span>
                                        </a>
                                    </li>
                                @endif
                                @if (auth()->user()->role === 'owner')
                                    <li>
                                        <a class="group flex items-center px-3 py-2 rounded-lg transition-all duration-200 @if (Route::is('reports.*')) {{ 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' }}@else{{ 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400' }} @endif"
                                            href="{{ route('reports.daily') }}">
                                            <div
                                                class="w-2 h-2 rounded-full @if (Route::is('reports.*')) {{ 'bg-violet-500' }}@else{{ 'bg-gray-400 group-hover:bg-violet-400' }} @endif transition-colors duration-200">
                                            </div>
                                            <span
                                                class="ml-3 text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Reports</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- More group -->
            <div>
                <h3 class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold pl-3 mb-4 tracking-wider">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Akun</span>
                </h3>
                <ul class="space-y-2">
                    <!-- Profile -->
                    <li>
                        <a class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-violet-600 dark:hover:text-violet-400"
                            href="{{ route('profile.show') }}">
                            <div
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-violet-100 dark:group-hover:bg-violet-900/20 transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span
                                class="ml-3 font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Profile</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li>
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
                            <button type="submit"
                                class="group w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400">
                                <div
                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-red-100 dark:group-hover:bg-red-900/20 transition-all duration-200">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-200"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span
                                    class="ml-3 font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 transition-opacity duration-200">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button
                    class="text-gray-400 hover:text-violet-500 dark:text-gray-500 dark:hover:text-violet-400 transition-colors duration-200"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current sidebar-expanded:rotate-180 transition-transform duration-200"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
