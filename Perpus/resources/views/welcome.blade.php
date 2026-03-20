<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-white shadow fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 block flex items-center gap-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            PerpusKu
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

    <!-- Hero Section -->
    <div class="relative bg-blue-700 pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden mt-16">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-blue-800 opacity-90"></div>
            <!-- Decorative circle -->
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-600 blur-3xl opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full bg-blue-500 blur-3xl opacity-30"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl mb-6">
                Temukan Buku Terbaik <br class="hidden md:inline"/> Untuk Masa Depanmu
            </h1>
            <p class="mt-4 max-w-2xl text-xl text-blue-100 mx-auto mb-10">
                Akses ribuan koleksi buku perpustakaan secara digital. Mudah, cepat, dan nyaman.
            </p>

            <!-- Search Bar -->
            <div class="max-w-3xl mx-auto">
                <form action="{{ route('home') }}" method="GET" class="relative flex items-center w-full h-14 rounded-full focus-within:shadow-lg bg-white overflow-hidden shadow-xl">
                    <div class="grid place-items-center h-full w-12 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                    class="peer h-full w-full outline-none text-sm text-gray-700 pr-2 border-0 focus:ring-0 bg-transparent"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    id="search"
                    placeholder="Cari judul buku atau penulis..." />
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold h-full px-8 transition-colors">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Catalog Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-20">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Koleksi Terbaru</h2>

        @if($books->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($books as $book)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden group flex flex-col h-full">
                    <div class="relative pt-[140%] overflow-hidden bg-gray-100">
                        @if($book->cover_image)
                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        @if($book->stock > 0)
                            <div class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Tersedia</div>
                        @else
                            <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Dipinjam</div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-sm text-blue-600 font-semibold mb-1 truncate">{{ $book->author }}</p>
                        <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2 leading-tight">{{ $book->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4">Penerbit: {{ $book->publisher }} ({{ $book->year }})</p>

                        <div class="mt-auto">
                            @auth
                                <form action="{{ route('borrowing.store', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" @if($book->stock <= 0) disabled @endif class="w-full text-center py-2.5 rounded-lg font-medium transition-colors border {{ $book->stock > 0 ? 'border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white' : 'border-gray-300 text-gray-400 cursor-not-allowed bg-gray-50' }}">
                                        {{ $book->stock > 0 ? 'Pinjam Buku' : 'Stok Habis' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center py-2.5 rounded-lg font-medium text-blue-600 border border-blue-600 hover:bg-blue-50 transition-colors">
                                    Login untuk Pinjam
                                </a>
                            @endauth
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

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold mb-4 flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                PerpusKu
            </h2>
            <p class="text-gray-400">© {{ date('Y') }} Perpustakaan Digital.</p>
        </div>
    </footer>

</body>
</html>
