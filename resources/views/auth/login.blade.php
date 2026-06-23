<x-guest-layout>
    <x-auth-session-status class="mb-4 text-center text-sm font-medium text-green-400" :status="session('status')" />

    <h2 class="text-xl font-bold text-white text-center mb-6">Selamat Datang</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                   class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-white text-sm transition" 
                   placeholder="admin@rental.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Kata Sandi</label>
            <input id="password" type="password" name="password" required 
                   class="w-full px-4 py-2.5 bg-slate-900/50 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 text-white text-sm transition" 
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="flex items-center justify-between text-xs text-slate-400">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-red-600 focus:ring-red-500" name="remember">
                <span class="ms-2">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="hover:text-white hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold text-sm tracking-wide shadow-lg shadow-red-900/50 active:scale-[0.99] transition-all duration-150 cursor-pointer text-center">
            LOG IN
        </button>

        <div class="pt-2 text-center">
            <a class="text-sm font-semibold text-red-500 hover:text-red-400 hover:underline" href="{{ route('register') }}">
                Belum punya akun? Daftar di sini
            </a>
        </div>
    </form>
</x-guest-layout>