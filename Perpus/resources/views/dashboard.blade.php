<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman Buku</h3>
                <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium">← Kembali ke Katalog</a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm text-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($borrowings->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Anda belum meminjam buku apa pun. <a href="{{ route('home') }}" class="text-blue-600 hover:underline font-medium">Telusuri katalog sekarang</a>.
                </div>
            @else
                <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-100">
                    <ul class="divide-y divide-gray-100">
                        @foreach($borrowings as $borrowing)
                        <li>
                            <div class="px-4 py-5 sm:px-6 hover:bg-gray-50 flex flex-col md:flex-row md:items-center justify-between transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-20 w-14 bg-gray-100 rounded overflow-hidden mr-4 shadow-sm border border-gray-200">
                                        @if($borrowing->book->cover_image)
                                            <img src="{{ Storage::url($borrowing->book->cover_image) }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-base font-bold text-gray-900 mb-1">
                                            {{ $borrowing->book->title }}
                                        </div>
                                        <div class="text-sm text-blue-600 font-medium mb-1">
                                            {!! $borrowing->book->author !!}
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500">
                                            Dipinjam: {{ $borrowing->borrowed_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-6 flex-shrink-0">
                                    @if($borrowing->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">Menunggu Konfirmasi</span>
                                    @elseif($borrowing->status === 'dipinjam')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200 shadow-sm">Sedang Dipinjam</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200 shadow-sm">Telah Dikembalikan</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
