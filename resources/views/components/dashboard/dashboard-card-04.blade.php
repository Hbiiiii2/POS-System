<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700/60 hover:shadow-xl transition-all duration-300 group">
    <div class="px-6 pt-6 pb-4">
        <header class="flex justify-between items-start mb-4">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-r from-orange-500 to-red-600 shadow-lg group-hover:shadow-xl transition-all duration-300">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors duration-200">Customers</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total visitors</p>
                </div>
            </div>
            <!-- Menu button -->
            <div class="relative inline-flex" x-data="{ open: false }">
                <button
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-all duration-200"          
                    aria-haspopup="true"
                    @click.prevent="open = !open"
                    :aria-expanded="open"
                >
                    <span class="sr-only">Menu</span>
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>
                <div
                    class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-xl shadow-lg overflow-hidden mt-1"                
                    @click.outside="open = false"
                    @keydown.escape.window="open = false"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak                
                >
                    <ul>
                        <li>
                            <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 flex py-2 px-3 transition-colors duration-200" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">View All</a>
                        </li>
                        <li>
                            <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-orange-900/20 flex py-2 px-3 transition-colors duration-200" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Add New</a>
                        </li>
                        <li>
                            <a class="font-medium text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex py-2 px-3 transition-colors duration-200" href="#0" @click="open = false" @focus="open = true" @focusout="open = false">Remove</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        
        <div class="flex items-end justify-between">
            <div class="flex items-baseline space-x-2">
                <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($dataFeed->sumDataSet(4, 1)) }}</div>
                <div class="flex items-center text-sm font-semibold text-green-600 dark:text-green-400 px-2 py-1 bg-green-100 dark:bg-green-900/30 rounded-full">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414-1.414L14.586 7H12z" clip-rule="evenodd" />
                    </svg>
                    +23%
                </div>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500 dark:text-gray-400">vs yesterday</div>
                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($dataFeed->sumDataSet(4, 1) - 7) }}</div>
            </div>
        </div>
    </div>
    
    <!-- Chart built with Chart.js 3 -->
    <!-- Check out src/js/components/dashboard-card-04.js for config -->
    <div class="grow max-sm:max-h-[128px] xl:max-h-[128px] px-6 pb-4">
        <!-- Change the height attribute to adjust the chart height -->
        <canvas id="dashboard-card-04" width="389" height="128"></canvas>
    </div>
</div>