<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Perpustakaan SMK Insan Global</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal" x-data="{ showModal: false, activeBook: {} }">

    <!-- Navbar -->
    <nav class="bg-white shadow fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 block flex items-center gap-2">
                            <span class="material-icons text-3xl">local_library</span>
                            Perpustakaan SMK Insan Global
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm">Daftar</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Carousel) -->
    <div class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden mt-16"
         x-data="{ 
            current: 0, 
            images: [
                'https://images.unsplash.com/photo-1512820790803-83ca734da794',
                'https://images.unsplash.com/photo-1541963463532-d68292c34b19',
                'https://images.unsplash.com/photo-1481627834876-b7833e8f5570'
            ] 
         }"
         x-init="setInterval(() => { current = (current + 1) % images.length }, 5000)">
        
        <template x-for="(img, index) in images" :key="index">
            <div x-show="current === index" 
                 x-transition.opacity.duration.1000ms
                 class="absolute inset-0 bg-cover bg-center"
                 :style="`background-image: url('${img}?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');`">
            </div>
        </template>
        
        <div class="absolute inset-0 bg-blue-900 opacity-60"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl mb-6 drop-shadow-lg">
                Temukan Buku Terbaik <br class="hidden md:inline"/> Untuk Masa Depanmu
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-blue-50 mx-auto mb-10 drop-shadow-md">
                Akses koleksi buku dan e-book perpustakaan SMK Insan Global secara digital. Mudah, cepat, dan nyaman.
            </p>

            <!-- Search Bar with Genre Filter -->
            <div class="max-w-4xl mx-auto">
                <form action="{{ route('home') }}" method="GET" class="relative flex flex-col md:flex-row items-center w-full shadow-2xl rounded-lg md:rounded-full bg-white overflow-hidden">
                    
                    <select name="genre" class="h-14 w-full md:w-48 border-0 focus:ring-0 bg-gray-50 text-gray-700 font-medium px-4 border-b md:border-b-0 md:border-r border-gray-200 outline-none cursor-pointer hover:bg-gray-100 transition-colors">
                        <option value="">Semua Genre</option>
                        <option value="Fiksi" {{ request('genre') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                        <option value="Non-Fiksi" {{ request('genre') == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                        <option value="Edukasi" {{ request('genre') == 'Edukasi' ? 'selected' : '' }}>Edukasi</option>
                        <option value="Teknologi" {{ request('genre') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                        <option value="Sejarah" {{ request('genre') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="Sastra" {{ request('genre') == 'Sastra' ? 'selected' : '' }}>Sastra</option>
                    </select>
                    
                    <div class="flex-grow h-14 w-full flex items-center">
                        <div class="grid place-items-center h-full w-12 text-gray-400">
                            <span class="material-icons">search</span>
                        </div>
                        <input
                        class="peer h-full w-full outline-none text-sm text-gray-700 pr-2 border-0 focus:ring-0 bg-transparent"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul buku atau penulis..." />
                    </div>
                    
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold h-14 w-full md:w-32 transition-colors flex justify-center items-center">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Catalog Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-20">
        <div class="flex justify-between items-end mb-8 border-b pb-4">
            <h2 class="text-3xl font-bold text-gray-800">Koleksi Terbaru</h2>
        </div>

        @if($books->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <span class="material-icons text-6xl text-gray-300 mb-4">search_off</span>
                <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($books as $book)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 overflow-hidden group flex flex-col h-full cursor-pointer"
                     @click="showModal = true; activeBook = {{ Illuminate\Support\Js::from($book) }}; activeBook.cover_url = '{{ $book->cover_image ? Storage::url($book->cover_image) : '' }}'; activeBook.read_url = '{{ route('books.read', $book->id) }}'">
                    <div class="relative pt-[140%] overflow-hidden bg-gray-100">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <span class="material-icons text-6xl">menu_book</span>
                            </div>
                        @endif
                        
                        <!-- Genre Badge -->
                        @if($book->genre)
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur text-blue-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $book->genre }}</div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                            <span class="text-white opacity-0 group-hover:opacity-100 bg-blue-600 px-4 py-2 rounded-full font-medium transition-opacity flex items-center gap-2">
                                <span class="material-icons text-sm">visibility</span> Detail
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-sm text-blue-600 font-semibold mb-1 truncate">{{ $book->author }}</p>
                        <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4">Penerbit: {{ $book->publisher }} ({{ $book->year }})</p>

                        <div class="mt-auto">
                            <button type="button" class="w-full h-11 flex items-center justify-center rounded-lg font-medium transition-colors border border-blue-600 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                                <span class="material-icons text-sm mr-2">library_books</span> Detail Buku
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Buku -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" @click="showModal = false" class="fixed inset-0 transition-opacity" aria-hidden="true" x-transition.opacity>
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>
            
            <div x-show="showModal" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-100">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                    <!-- Close button -->
                    <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                        <span class="material-icons">close</span>
                    </button>
                    
                    <div class="sm:flex sm:items-start gap-8">
                        <div class="w-full sm:w-1/3 flex-shrink-0 mb-6 sm:mb-0">
                            <template x-if="activeBook.cover_url">
                                <img :src="activeBook.cover_url" class="w-full h-auto rounded-xl shadow-lg border border-gray-100" alt="">
                            </template>
                            <template x-if="!activeBook.cover_url">
                                <div class="w-full aspect-[2/3] bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200 shadow-sm">
                                    <span class="material-icons text-6xl">menu_book</span>
                                </div>
                            </template>
                        </div>
                        <div class="w-full sm:w-2/3">
                            <div class="flex items-center gap-2 mb-2">
                                <template x-if="activeBook.genre">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full shadow-sm" x-text="activeBook.genre"></span>
                                </template>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mb-2 leading-tight" x-text="activeBook.title"></h3>
                            <p class="text-lg font-semibold text-blue-600 mb-6" x-text="activeBook.author"></p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div><span class="text-gray-500 block text-xs uppercase tracking-wider mb-1">Penerbit</span> <strong x-text="activeBook.publisher"></strong></div>
                                <div><span class="text-gray-500 block text-xs uppercase tracking-wider mb-1">Tahun</span> <strong x-text="activeBook.year"></strong></div>
                            </div>

                            <div class="text-gray-600 mb-6">
                                <h4 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                                    <span class="material-icons text-sm text-blue-600">article</span> Sinopsis
                                </h4>
                                <p class="text-sm leading-relaxed" x-text="activeBook.description || 'Tidak ada deskripsi yang tersedia untuk buku ini.'"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <a :href="activeBook.read_url" class="w-full inline-flex justify-center items-center rounded-xl border border-transparent shadow-sm px-8 py-3 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-all transform hover:scale-105">
                        <span class="material-icons text-sm mr-2">menu_book</span> Baca E-Book
                    </a>
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center items-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold mb-4 flex items-center justify-center gap-2">
                <span class="material-icons">local_library</span>
                Perpustakaan SMK Insan Global
            </h2>
            <p class="text-gray-400">© {{ date('Y') }} Perpustakaan SMK Insan Global.</p>
        </div>
    </footer>

</body>
</html>
