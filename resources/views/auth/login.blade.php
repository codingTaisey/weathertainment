<x-guest-layout>
    <div class="flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 space-y-6">

            <!-- Title -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">ログイン</h2>
                <p class="text-gray-600 mt-2">アカウントにログインしてください</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="メールアドレス" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="パスワード" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">ログイン状態を維持する</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        パスワードを忘れましたか？
                    </a>
                    @endif
                </div>

                <div class="space-y-4">
                    <!-- Login Button -->
                    <x-primary-button class="w-full justify-center">
                        ログイン
                    </x-primary-button>

                    <!-- Demo Login Button -->
                    <a href="{{ route('demo.login') }}" class="w-full justify-center inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        デモアカウントで入る
                    </a>
                </div>
            </form>

            <p class="text-sm text-center text-gray-600">
                アカウントをお持ちでない方は <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">こちらから登録</a>
            </p>
        </div>
    </div>
</x-guest-layout>