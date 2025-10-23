<x-app-layout>
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- メインタイトル --}}
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-2">
                {{-- 天気ロゴ --}}
                <svg class="w-16 h-16 text-white mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-2.666-2.886 5.25 5.25 0 00-9.772-.812A4.5 4.5 0 002.25 15z" />
                </svg>
                <h1 class="text-4xl font-bold text-white">今日の生活あるある指数</h1>
            </div>
            <p class="text-lg text-white/80">毎日の天気を楽しみに変える、新感覚のお天気予報</p>
        </div>

        {{-- メインカード --}}
        <div class="w-full max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-6 sm:p-8">
            {{-- 地域選択 --}}
            <div class="mb-6">
                <x-region-selector :currentPrefecture="$selectedCity" />
            </div>

            @if (isset($weatherData) && $weatherData)
            {{-- 天気情報 --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $weatherData['name'] }} の今日の予報</h2>
                <p class="text-gray-600 text-lg mb-2 capitalize">{{ $weatherData['weather'][0]['description'] }}</p>
                <p class="text-red-500 text-5xl font-bold">{{ number_format($weatherData['main']['temp'], 1) }} °C</p>
                <p class="text-blue-500 text-2xl font-semibold mt-1">{{ $weatherData['main']['humidity'] }}%</p>
            </div>

            {{-- 区切り線 --}}
            <hr class="border-gray-200 mb-6">

            {{-- 生活指数 --}}
            <h3 class="text-xl font-bold text-gray-800 mb-4 text-left">面白指数</h3>
            <div x-data="{ open: 'sneeze' }" class="space-y-2">

                {{-- くしゃみ確率 --}}
                <div class="index-item border-b border-gray-200 pb-2">
                    <div @click="open = (open === 'sneeze' ? '' : 'sneeze')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">くしゃみ確率</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-red-500">{{ $sneezeRate }} %</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'sneeze'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'sneeze'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">今日くしゃみが出る可能性を予測します。</p>
                        <p>【計算方法】湿度と風速から算出しています。</p>
                        <p class="mt-1 italic">あなたの鼻のムズムズを、勝手にお知らせ！</p>
                    </div>
                </div>

                {{-- 前髪崩壊率 --}}
                <div class="index-item border-b border-gray-200 pb-2">
                    <div @click="open = (open === 'fringe' ? '' : 'fringe')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">前髪崩壊率</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-red-500">{{ $fringeCollapseRate }} %</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'fringe'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'fringe'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">今日のあなたの前髪が、どれだけ持ちこたえられるかを予測します。</p>
                        <p>【計算方法】湿度と風速から算出しています。</p>
                        <p class="mt-1 italic">湿度は最大の敵。今日のセットは、もはや祈りです。</p>
                    </div>
                </div>

                {{-- 傘忘れ後悔度 --}}
                <div class="index-item border-b border-gray-200 pb-2">
                    <div @click="open = (open === 'umbrella' ? '' : 'umbrella')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">傘忘れ後悔度</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-red-500">{{ $umbrellaRegretLevel }} %</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'umbrella'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'umbrella'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">傘を持たずに外出した場合の後悔度を予測します。</p>
                        <p>【計算方法】天気概要が「雨」系の予報かどうかで判定しています。</p>
                        <p class="mt-1 italic">「降らないでしょ」が、今日の命取りになるかもしれない。</p>
                    </div>
                </div>

                {{-- 猫が丸くなる確率 --}}
                <div class="index-item border-b border-gray-200 pb-2">
                    <div @click="open = (open === 'cat' ? '' : 'cat')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">猫が丸くなる確率</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-red-500">{{ $catCurlRate }} %</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'cat'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'cat'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">あなたの家の猫が、どれくらい丸くなるかを予測します。</p>
                        <p>【計算方法】気温が低いほど高くなるように算出しています。</p>
                        <p class="mt-1 italic">完璧なアンモニャイトが観測できるかもしれません。</p>
                    </div>
                </div>

                {{-- 洗濯物カビリスク --}}
                <div class="index-item border-b border-gray-200 pb-2">
                    <div @click="open = (open === 'laundry' ? '' : 'laundry')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">洗濯物カビリスク</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold text-red-500">{{ $laundryMoldRisk }} %</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'laundry'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'laundry'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">部屋干しした洗濯物から、あのイヤな臭いが発生する危険度です。</p>
                        <p>【計算方法】湿度と、天気が「雨」系かどうかを元に算出しています。</p>
                        <p class="mt-1 italic">勇気ある撤退（＝乾燥機）も、立派な戦術です。</p>
                    </div>
                </div>

                {{-- ダルさ予報 --}}
                <div class="index-item">
                    <div @click="open = (open === 'lazy' ? '' : 'lazy')" class="flex justify-between items-center cursor-pointer py-2">
                        <span class="font-semibold text-gray-700">ダルさ予報</span>
                        <div class="flex items-center space-x-2">
                            <span class="text-lg font-bold" style="color: {{ $lazinessExcuse['color'] }};">Lv. {{ $lazinessExcuse['level'] }}</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{'rotate-180': open === 'lazy'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="open === 'lazy'" x-transition class="pt-2 text-sm text-gray-600 text-left">
                        <p class="font-bold">気圧の変化による、今日のあなたのコンディション予測です。</p>
                        <p>【計算方法】気圧の絶対値が低いほど、レベルが高くなります。</p>
                        <p class="mt-1 italic">全ての不調は、気圧のせいにすればいい。</p>
                    </div>
                </div>
            </div>

            {{-- アクションボタン --}}
            <div class="mt-8 space-y-4">
                <a href="{{ $twitterShareUrl }}" target="_blank" class="w-full bg-black text-white py-3 px-4 rounded-full flex items-center justify-center space-x-2 hover:bg-gray-800 transition-colors font-bold text-base">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                    <span>結果をXでシェアする</span>
                </a>
                <a href="{{ route('ranking') }}" class="w-full text-blue-600 text-center py-2 hover:text-blue-800 transition-colors font-semibold">
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
</x-app-layout>