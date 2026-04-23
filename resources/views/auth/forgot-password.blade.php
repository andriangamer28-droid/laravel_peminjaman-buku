<x-guest-layout>
    <div class="space-y-8">
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-slate-900">Lupa Kata Sandi?</h2>
            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                Tenang saja. Cukup masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>
        </div>

        @if (session('status'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-500 ml-1 mb-2">
                    Alamat Email
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-200 placeholder:text-slate-400"
                        placeholder="nama@email.com">
                </div>
                @error('email') 
                    <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p> 
                @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl text-white bg-slate-900 hover:bg-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 transform active:scale-[0.98]">
                Kirim Tautan Reset
            </button>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                &larr; Kembali ke halaman login
            </a>
        </div>
    </div>
</x-guest-layout>