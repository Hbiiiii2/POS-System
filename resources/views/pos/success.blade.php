<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Transaksi Berhasil!</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">Transaksi #{{ $transaction->id }} telah berhasil disimpan</p>
        </div>

        <!-- Transaction Details -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700 mb-8">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Transaksi</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Transaction Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Transaksi</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">ID Transaksi:</span>
                                <span class="font-medium text-gray-900 dark:text-white">#{{ $transaction->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tanggal:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Kasir:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran:</span>
                                <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $transaction->payment_method }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Pembayaran</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Belanja:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Bayar:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Kembalian:</span>
                                <span class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->payment->change, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Produk yang Dibeli</h3>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="space-y-3">
                            @foreach($transaction->transactionDetails as $detail)
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $detail->product->name }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">({{ $detail->product->product_code }})</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                                    <div class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- Print Receipt Button -->
            <a href="{{ route('pos.receipt', $transaction->id) }}" target="_blank" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Nota
            </a>

            <!-- Continue Shopping Button -->
            <a href="{{ route('pos.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Lanjutkan Transaksi
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mt-6 text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-7a1 1 0 10-2 0v3a1 1 0 01-1 1H9a1 1 0 100 2h1a3 3 0 003-3v-3z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif
    </div>
</x-app-layout> 