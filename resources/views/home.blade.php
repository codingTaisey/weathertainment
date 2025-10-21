<x-guest-layout>
    <div class="flex items-center justify-center p-4 py-12">

        {{-- メインカード --}}
        <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl p-8">
            {{-- 地域選択 --}}
            <div class="mb-6">
                <x-region-selector :currentPrefecture="$weatherData['name'] ?? '東京都'" />
            </div>

            @if (isset($weatherData) && $weatherData)
            {{-- 天気情報 --}}
            <div class="text-center mb-6">
                <p class="text-white text-lg mb-2">{{ $weatherData['weather'][0]['description'] }}</p>
                <p class="text-red-500 text-3xl font-bold">{{ number_format($weatherData['main']['temp'], 1) }} °C</p>
                <p class="text-red-500 text-xl font-semibold">{{ $weatherData['main']['humidity'] }}%</p>
            </div>

            {{-- 区切り線 --}}
            <hr class="border-gray-600 mb-6">

            {{-- 生活指数 --}}
            <div class="space-y-3 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-white">くしゃみ確率</span>
                    <span class="text-red-500 font-bold">{{ $sneezeRate }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white">前髪崩壊率</span>
                    <span class="text-red-500 font-bold">{{ $fringeCollapseRate }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white">傘忘れ後悔度</span>
                    <span class="text-red-500 font-bold">{{ $umbrellaRegretLevel }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white">猫が丸くなる確率</span>
                    <span class="text-red-500 font-bold">{{ $catCurlRate }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white">洗濯物カビリスク</span>
                    <span class="text-red-500 font-bold">{{ $laundryMoldRisk }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-white">ダルさ予報</span>
                    <span class="text-green-500 font-bold">Lv. {{ $lazinessExcuse['level'] }}</span>
                </div>
            </div>

            {{-- 区切り線 --}}
            <hr class="border-gray-600 mb-6">

            {{-- アクションボタン --}}
            <div class="space-y-4">
                <a href="{{ $twitterShareUrl }}" target="_blank" class="w-full bg-black text-white py-3 px-4 rounded-lg flex items-center justify-center space-x-2 hover:bg-gray-900 transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                    <span>結果をXでシェアする</span>
                </a>
                <a href="{{ route('ranking') }}" class="w-full text-blue-400 text-center py-2 hover:text-blue-300 transition-colors">
                    ランキングを見る
                </a>
            </div>
            @else
            <div class="text-center text-red-500">
                <p>天気情報の取得に失敗しました。</p>
                <p class="text-sm mt-2">APIキーの設定を確認してください。</p>
            </div>
            @endif
        </div>
    </div>
</x-guest-layout>