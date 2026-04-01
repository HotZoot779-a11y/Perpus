<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
               {{ $book->title }}
            </h2>
            <a href="{{ url()->previous() == route('home') ? route('home') : route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6" style="height: calc(100vh - 150px);">
        <div class="w-full px-4 h-full">
            <div class="bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl border border-gray-700 h-full p-2">
                <iframe src="{{ Storage::url($book->pdf_file) }}" class="w-full h-full rounded-lg bg-white" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</x-app-layout>
