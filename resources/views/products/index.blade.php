<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Produk</h1>
                </div>
                <div class="flex flex-wrap items-center space-x-2">
                    <a href="{{ route('products.create') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Tambah Produk</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="form-input w-full" />
                </div>
                <button type="submit" class="btn bg-slate-800 hover:bg-slate-900 text-white">Cari</button>
                @if(request('search'))
                    <a href="{{ route('products.index') }}" class="btn border-slate-200 hover:border-slate-300 text-slate-600">Reset</a>
                @endif
            </form>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Products -->
            <div class="col-span-full">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Daftar Produk</h2>
                    </header>
                    <div class="p-3">
                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-700/50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">No</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Kode</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Nama Produk</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Kategori</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Stok</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Harga</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-left">Satuan</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">Aksi</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-100 dark:divide-slate-700">
                                    @forelse($products as $index => $product)
                                    <tr>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">{{ $index + 1 }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left font-medium text-slate-800 dark:text-slate-100">{{ $product->product_code }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">{{ $product->name }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">{{ $product->category->name }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">
                                                <span class="inline-flex text-xs font-medium rounded-full px-2.5 py-0.5 {{ $product->stock > 10 ? 'bg-emerald-100 text-emerald-600' : ($product->stock > 0 ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600') }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-left">{{ $product->unit }}</div>
                                        </td>
                                        <td class="p-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('products.edit', $product) }}" class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400">
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                                            <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM12.6 16H16v-3.4l-1-1L11.6 15l1 1zM15.7 12.3l1-1L13.4 9l-1 1 3.3 2.3z"/>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:text-rose-700">
                                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                                                                <path d="M5 5v5h5V5H5zM4 1h8v2H4V1zm0 12h8v2H4v-2z"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="p-2 whitespace-nowrap">
                                            <div class="text-center text-slate-500 dark:text-slate-400">Tidak ada produk</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($products->hasPages())
                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 