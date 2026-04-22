<x-app-layout>
    <div class="min-h-screen flex items-center justify-center py-12">
        <div class="text-center">
            <p class="text-6xl font-bold text-indigo-600">403</p>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Akses Ditolak</h1>
            <p class="mt-2 text-gray-500">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <div class="mt-6">
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
