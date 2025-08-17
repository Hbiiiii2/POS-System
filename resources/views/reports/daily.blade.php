<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Laporan Harian</h1>
                </div>
                <div class="flex flex-wrap items-center space-x-2">
                    <form action="{{ route('reports.daily') }}" method="GET" class="flex gap-2">
                        <input type="date" name="date" value="{{ $date }}" class="form-input" />
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Filter</button>
                    </form>
                    <a href="{{ route('reports.export') }}?range=daily&value={{ $date }}" class="btn bg-emerald-500 hover:bg-emerald-600 text-white">
                        Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Penjualan</div>
                            <div class="text-2xl font-bold text-slate-800 dark:text-slate-100">Rp {{ number_format($total_sales, 0, ',', '.') }}</div>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Transaksi</div>
                            <div class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $total_transactions }}</div>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Rata-rata per Transaksi</div>
                            <div class="text-2xl font-bold text-slate-800 dark:text-slate-100">
                                Rp {{ $total_transactions > 0 ? number_format($total_sales / $total_transactions, 0, ',', '.') : '0' }}
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full lg:col-span-6">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Metode Pembayaran</h2>
                    </header>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($payment_methods as $method => $amount)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-3 
                                        {{ $method === 'cash' ? 'bg-green-500' : 
                                           ($method === 'qris' ? 'bg-blue-500' : 'bg-purple-500') }}"></div>
                                    <span class="font-medium text-slate-800 dark:text-slate-100">{{ strtoupper($method) }}</span>
                                </div>
                                <span class="font-bold text-slate-800 dark:text-slate-100">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions List -->
            <div class="col-span-full lg:col-span-6">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Daftar Transaksi</h2>
                    </header>
                    <div class="p-3">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">ID</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Kasir</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Total</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Metode</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                                    @forelse($transactions as $transaction)
                                    <tr>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left font-medium text-slate-800 dark:text-slate-100">#{{ $transaction->id }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">{{ $transaction->user->name }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">
                                                <span class="inline-flex text-xs font-medium rounded-full px-2.5 py-0.5 
                                                    {{ $transaction->payment_method === 'cash' ? 'bg-green-100 text-green-600' : 
                                                       ($transaction->payment_method === 'qris' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600') }}">
                                                    {{ strtoupper($transaction->payment_method) }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="p-2 whitespace-nowrap">
                                            <div class="text-center text-slate-500 dark:text-slate-400">Tidak ada transaksi</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 