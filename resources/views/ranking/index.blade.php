<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('全国生活指数ランキング') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- メインタイトル -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-yellow-500 mr-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">全国生活指数ランキング</h1>
                </div>
                <p class="text-lg text-gray-600 dark:text-gray-300">今日の全国47都道府県の生活指数ランキングをチェック！</p>
            </div>

            <!-- 統計情報カード -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">データ更新日</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['updateDate'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">対象都道府県</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['prefectureCount'] }}都道府県</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">平均{{ $selectedType === 'sneeze' ? 'くしゃみ確率' : ($selectedType === 'fringe_collapse' ? '前髪崩壊率' : '洗濯物カビリスク') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['averageScore'] }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">平均風速</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">-- m/s</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ランキング表示セクション -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <!-- タブ切り替え -->
                    <div class="flex border-b border-gray-200 dark:border-gray-700 mb-6">
                        <button onclick="switchTab('sneeze')"
                            class="tab-button px-6 py-3 text-sm font-medium {{ $selectedType === 'sneeze' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            くしゃみ確率
                        </button>
                        <button onclick="switchTab('fringe_collapse')"
                            class="tab-button px-6 py-3 text-sm font-medium {{ $selectedType === 'fringe_collapse' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            前髪崩壊率
                        </button>
                        <button onclick="switchTab('laundry_mold')"
                            class="tab-button px-6 py-3 text-sm font-medium {{ $selectedType === 'laundry_mold' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            洗濯物カビリスク
                        </button>
                    </div>

                    <!-- ランキングタイトルと更新ボタン -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-gray-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $selectedType === 'sneeze' ? 'くしゃみ確率ランキング' : ($selectedType === 'fringe_collapse' ? '前髪崩壊率ランキング' : '洗濯物カビリスクランキング') }}
                            </h3>
                        </div>
                        <form method="POST" action="{{ route('ranking.update') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded border border-blue-500">
                                更新
                            </button>
                        </form>
                    </div>

                    <!-- ランキングテーブル -->
                    @if($rankings[$selectedType]->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">順位</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">都道府県</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">スコア</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($rankings[$selectedType] as $ranking)
                                <tr class="{{ $ranking->rank <= 3 ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        @if($ranking->rank == 1)
                                        <span class="text-yellow-500">🥇</span>
                                        @elseif($ranking->rank == 2)
                                        <span class="text-gray-400">🥈</span>
                                        @elseif($ranking->rank == 3)
                                        <span class="text-orange-500">🥉</span>
                                        @endif
                                        {{ $ranking->rank }}位
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $ranking->prefecture }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $ranking->score }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">データがありません</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 週間推移セクション -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">週間推移</h3>
                    </div>

                    <div class="flex items-center mb-6">
                        <select id="trendType" class="mr-4 border border-gray-300 rounded-md px-3 py-2">
                            <option value="sneeze" {{ $selectedType === 'sneeze' ? 'selected' : '' }}>くしゃみ確率</option>
                            <option value="fringe_collapse" {{ $selectedType === 'fringe_collapse' ? 'selected' : '' }}>前髪崩壊率</option>
                            <option value="laundry_mold" {{ $selectedType === 'laundry_mold' ? 'selected' : '' }}>洗濯物カビリスク</option>
                        </select>
                        <button onclick="showTrend()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            推移を表示
                        </button>
                    </div>

                    <div id="chartContainer" class="hidden">
                        <canvas id="trendChart" width="400" height="200"></canvas>
                    </div>

                    <div id="chartPlaceholder" class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">推移を表示するには上のボタンをクリックしてください</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // タブ切り替え機能
        function switchTab(type) {
            window.location.href = `{{ route('ranking') }}?type=${type}`;
        }

        // 週間推移グラフ表示
        function showTrend() {
            const type = document.getElementById('trendType').value;
            const chartContainer = document.getElementById('chartContainer');
            const chartPlaceholder = document.getElementById('chartPlaceholder');

            // プレースホルダーを非表示、チャートを表示
            chartPlaceholder.classList.add('hidden');
            chartContainer.classList.remove('hidden');

            // 既存のチャートを破棄
            if (window.trendChart) {
                window.trendChart.destroy();
            }

            // 週間データを取得（実際の実装ではAjaxで取得）
            const weeklyData = @json($weeklyData);

            const ctx = document.getElementById('trendChart').getContext('2d');
            window.trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: weeklyData.map(item => item.date),
                    datasets: [{
                        label: '平均スコア',
                        data: weeklyData.map(item => item.averageScore),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1
                    }, {
                        label: '最高スコア',
                        data: weeklyData.map(item => item.topScore),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>