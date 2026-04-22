<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-600">Perbarui informasi akun dan foto profil Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Foto Profil --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Foto Profil</label>
            <div class="flex items-center gap-5">
                {{-- Preview foto --}}
                <img id="foto-preview" src="{{ $user->fotoUrl() }}" alt="Foto Profil"
                    class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 shadow-sm">

                <div class="flex-1 space-y-2">
                    <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Ganti Foto
                        <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewFotoProfil(this)">
                    </label>
                    @if($user->foto)
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1" class="rounded border-gray-300 text-red-500">
                            <label for="hapus_foto" class="text-sm text-red-600 cursor-pointer">Hapus foto</label>
                        </div>
                    @endif
                    <p class="text-xs text-gray-400">JPG, PNG, WEBP · maks 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>

        {{-- Nama --}}
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Role badge --}}
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500">Role:</span>
            <span class="px-3 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Perubahan</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">✓ Tersimpan!</p>
            @endif
        </div>
    </form>
</section>

<script>
function previewFotoProfil(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('foto-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
