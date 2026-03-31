<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <span class="material-icons">menu_book</span> {{ __('Sedang Membaca: ') }} <span class="font-bold ml-1">{{ $book->title }}</span>
            </h2>
            <a href="{{ url()->previous() == route('home') ? route('home') : route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                <span class="material-icons text-sm mr-1">arrow_back</span> Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6" style="height: calc(100vh - 150px);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl border border-gray-700 h-full p-2">
                <iframe src="{{ Storage::url($book->pdf_file) }}" class="w-full h-full rounded-lg bg-white" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</x-app-layout>
