<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center">
                <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mr-4">← Kembali</a>
                <h3 class="text-2xl font-bold text-gray-800">Formulir Buku</h3>
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

                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                        <!-- Judul -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Penulis -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Penerbit -->
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                            <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Tahun Terbit -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                            <input type="number" name="year" id="year" value="{{ old('year') }}" required min="1800" max="{{ date('Y') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 hover:bg-white transition-colors">
                        </div>

                        <!-- Detail Tambahan (Backdrop) -->
                        <div class="col-span-1 md:col-span-2 bg-blue-50/50 p-6 rounded-xl border border-blue-100 shadow-inner my-4">
                            <h4 class="font-semibold text-blue-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Detail Tambahan & E-Book
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Genre -->
                                <div>
                                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                                    <select name="genre" id="genre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white">
                                        <option value="">Pilih Genre</option>
                                        <option value="Fiksi" {{ old('genre') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                        <option value="Non-Fiksi" {{ old('genre') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                        <option value="Edukasi" {{ old('genre') == 'Edukasi' ? 'selected' : '' }}>Edukasi</option>
                                        <option value="Teknologi" {{ old('genre') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                        <option value="Sejarah" {{ old('genre') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Sastra" {{ old('genre') == 'Sastra' ? 'selected' : '' }}>Sastra</option>
                                    </select>
                                </div>

                                <!-- PDF File -->
                                <div>
                                    <label for="pdf_file" class="block text-sm font-medium text-gray-700 mb-1">File E-Book (PDF) <span class="text-red-500">*</span></label>
                                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md shadow-sm">
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-span-1 md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap Buku</label>
                                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Sampul Buku -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampul Buku</label>
                            <div class="mt-1 flex flex-col sm:flex-row items-center gap-6">
                                <!-- Preview Area -->
                                <div id="preview-container" class="hidden shrink-0 w-32 h-44 rounded-md shadow-md overflow-hidden border border-gray-200">
                                    <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                </div>
                                <!-- Upload Area -->
                                <div class="flex-grow w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 bg-gray-50 hover:bg-blue-50 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="cover_image" class="relative cursor-pointer bg-transparent rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Unggah gambar</span>
                                                <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">atau seret dan lepas</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG ukuran maksimal 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons Form -->
                        <div class="col-span-1 md:col-span-2 flex items-center justify-end mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.books.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors text-sm">
                                Simpan Buku
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Script Preview -->
    <script>
        function previewImage(event) {
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '#';
                previewContainer.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
