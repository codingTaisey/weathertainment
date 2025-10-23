<x-guest-layout>
    <div class="flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 space-y-6">

            <!-- Title -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">ユーザー登録</h2>
                <p class="text-gray-600 mt-2">新しいアカウントを作成</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" value="お名前" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" value="メールアドレス" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" value="パスワード" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" value="パスワード確認" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Prefecture -->
                <div>
                    <x-input-label for="prefecture" value="お住まいの都道府県" />
                    <select id="prefecture" name="prefecture" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="" selected disabled>選択してください</option>
                        @php
                        $prefectures = [
                        '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
                        '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
                        '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
                        '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
                        '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
                        '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
                        '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
                        ];
                        @endphp
                        @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture }}" {{ old('prefecture') == $prefecture ? 'selected' : '' }}>{{ $prefecture }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('prefecture')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center">
                    アカウント作成
                </x-primary-button>
            </form>

            <p class="text-sm text-center text-gray-600">
                既にアカウントをお持ちの方は <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">こちらからログイン</a>
            </p>
        </div>
    </div>
</x-guest-layout>