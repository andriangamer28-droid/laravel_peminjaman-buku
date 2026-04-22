<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium">{{ $kategori->nama }}</h3>
                        <p class="text-gray-600 mt-2">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <h4 class="font-medium mb-2">Buku dalam kategori ini:</h4>
                    @if($kategori->bukus->count() > 0)
                        <ul class="list-disc pl-5">
                            @foreach($kategori->bukus as $buku)
                                <li>{{ $buku->judul }} ({{ $buku->penulis }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Belum ada buku.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('kategori.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali ke daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>