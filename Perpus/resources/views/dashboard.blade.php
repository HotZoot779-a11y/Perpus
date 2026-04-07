<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buku Pinjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Daftar Pinjaman</h3>

                @if($borrowings->isEmpty())
                    <p class="text-gray-500">Anda belum meminjam buku apapun.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($borrowings as $borrowing)
                            <div class="bg-white rounded-xl shadow-md border hover:shadow-lg transition-shadow duration-300 overflow-hidden flex flex-col h-full">
                                <div class="p-4 flex-grow flex flex-col items-center">
                                    <div class="h-48 w-32 bg-gray-200 mb-4 rounded shadow-sm overflow-hidden flex-shrink-0">
                                        @if($borrowing->book->cover_image)
                                            <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="Cover {{ $borrowing->book->title }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-lg text-center text-gray-800 line-clamp-2" title="{{ $borrowing->book->title }}">{{ $borrowing->book->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $borrowing->book->author }}</p>

                                    <div class="mt-auto pt-4 w-full text-center">
                                        @if($borrowing->status === 'borrowed')

                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('books.read', $borrowing->book->id) }}" class="w-full inline-block bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">
                                                    Baca E-Book
                                                </a>
                                                <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                                    @csrf
                                                    <button type="submit" class="w-full bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded hover:bg-gray-300 transition duration-200">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full mb-3">Dikembalikan</span>
                                            <button disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-2 px-4 rounded cursor-not-allowed">
                                                Baca E-Book
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
