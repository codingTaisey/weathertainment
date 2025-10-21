<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService; // WeatherServiceをインポート
use App\Models\Ranking;         // Rankingモデルをインポート
use Carbon\Carbon;                // 日付操作ライブラリCarbonをインポート

class UpdateRankingCommand extends Command
{
    /**
     * コマンドのシグネチャ (名前)
     */
    protected $signature = 'ranking:update';

    /**
     * コマンドの説明
     */
    protected $description = 'Fetch weather data for all prefectures and update the rankings table';

    /**
     * コマンドのメイン処理を実行する
     *
     * @param WeatherService $weatherService Laravelが自動的に用意してくれる天気予報の専門家
     */
    public function handle(WeatherService $weatherService)
    {
        $this->info('ランキングの更新を開始します...');

        // === STEP 1: 日本の47都道府県のリストを用意する ===
        $prefectures = [
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
            '山梨県',
            '長野県',
            '岐阜県',
            '静岡県',
            '愛知県',
            '三重県',
            '滋賀県',
            '京都府',
            '大阪府',
            '兵庫県',
            '奈良県',
            '和歌山県',
            '鳥取県',
            '島根県',
            '岡山県',
            '広島県',
            '山口県',
            '徳島県',
            '香川県',
            '愛媛県',
            '高知県',
            '福岡県',
            '佐賀県',
            '長崎県',
            '熊本県',
            '大分県',
            '宮崎県',
            '鹿児島県',
            '沖縄県'
        ];

        // === STEP 2: 各都道府県の天気データを取得し、3種類のスコアを計算する ===
        $allScores = [
            'sneeze' => [],
            'fringe_collapse' => [],
            'laundry_mold' => []
        ];

        foreach ($prefectures as $prefecture) {
            $weatherData = $weatherService->getCurrentWeather($prefecture);
            if ($weatherData) {
                // 3種類のスコアを計算
                $sneezeScore = $weatherService->calculateSneezeRate($weatherData);
                $fringeScore = $weatherService->calculateFringeCollapseRate($weatherData);
                $laundryScore = $weatherService->calculateLaundryMoldRisk($weatherData);

                $allScores['sneeze'][] = [
                    'prefecture' => $prefecture,
                    'score' => $sneezeScore,
                ];
                $allScores['fringe_collapse'][] = [
                    'prefecture' => $prefecture,
                    'score' => $fringeScore,
                ];
                $allScores['laundry_mold'][] = [
                    'prefecture' => $prefecture,
                    'score' => $laundryScore,
                ];

                $this->line("{$prefecture} のスコアを計算しました: くしゃみ({$sneezeScore}) 前髪({$fringeScore}) 洗濯物({$laundryScore})");
            } else {
                $this->warn("{$prefecture} の天気情報が取得できませんでした。");
            }
            sleep(1); // APIへの連続リクエストを防ぐために1秒待機
        }

        // === STEP 3: 各ランキングタイプごとにスコアを高い順に並び替える ===
        $today = Carbon::today();

        foreach ($allScores as $type => $scores) {
            // スコア順にソート
            usort($scores, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            // 古いランキングデータを削除
            Ranking::where('type', $type)->where('ranking_date', $today)->delete();

            // 新しいランキングデータを保存
            foreach ($scores as $index => $data) {
                Ranking::create([
                    'type' => $type,
                    'ranking_date' => $today,
                    'prefecture' => $data['prefecture'],
                    'score' => $data['score'],
                    'rank' => $index + 1,
                ]);
            }

            $this->info("{$type} ランキングの更新が完了しました。");
        }

        $this->info('全ランキングの更新が完了しました！');
        return Command::SUCCESS;
    }
}
