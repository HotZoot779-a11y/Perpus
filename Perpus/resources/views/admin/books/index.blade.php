<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-800">Daftar Buku</h3>
                <a href="{{ route('admin.books.create') }}" class="font-bold py-2 px-4 rounded shadow-sm text-sm text-white bg-blue-600 hover:bg-blue-700 transition">
                    + Tambah Buku
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sampul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul & Penulis</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerbit & Tahun</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($books as $book)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-16 w-12 bg-gray-100 rounded overflow-hidden">
                                            @if($book->cover_image)
                                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-full w-full text-gray-400 p-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $book->author }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $book->publisher }}</div>
                                        <div class="text-sm text-gray-500">{{ $book->year }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $book->stock }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 border-b border-gray-200"></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($books->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $books->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
