<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center">
                <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mr-4">← Kembali</a>
                <h3 class="text-2xl font-bold text-gray-800">Edit Data Buku</h3>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Cover Preview -->
                    <div class="mb-8 flex justify-center">
                        <div class="relative w-32 h-48 bg-gray-100 rounded-md shadow flex items-center justify-center overflow-hidden border border-gray-200">
                            @if($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" class="object-cover w-full h-full" alt="Sampul Saat Ini">
                            @else
                                <span class="text-gray-400 text-sm p-4 text-center leading-tight">Belum ada<br>sampul</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                        <!-- Judul -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Penerbit -->
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                            <input type="text" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Tahun Terbit -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                            <input type="number" name="year" id="year" value="{{ old('year', $book->year) }}" required min="1800" max="{{ date('Y') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Sampul Buku (Ganti) -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Sampul (Opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex justify-center text-sm text-gray-600">
                                        <label for="cover_image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Pilih file gambar</span>
                                            <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">Abaikan jika tidak ingin mengganti sampul saat ini.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Form -->
                        <div class="col-span-1 md:col-span-2 flex items-center justify-end mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.books.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors text-sm">
                                Perbarui Buku
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
