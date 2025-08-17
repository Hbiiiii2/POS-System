<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Page header -->
        <div class="mb-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Edit Kategori</h1>
                </div>
                <div class="flex flex-wrap items-center space-x-2">
                    <a href="{{ route('categories.index') }}" class="btn border-slate-200 hover:border-slate-300 text-slate-600">
                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path d="M9.4 13.4l1.4-1.4L4.8 6H16V4H4.8l6.1-6.1L9.4-3.4 2 4l7.4 7.4z"/>
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full">
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100">Form Kategori</h2>
                    </header>
                    <div class="p-6">
                        <form action="{{ route('categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="name">Nama Kategori <span class="text-rose-500">*</span></label>
                                    <input id="name" class="form-input w-full" type="text" name="name" value="{{ old('name', $category->name) }}" required />
                                    @error('name')
                                        <div class="text-xs mt-1 text-rose-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('categories.index') }}" class="btn border-slate-200 hover:border-slate-300 text-slate-600">Batal</a>
                                    <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 