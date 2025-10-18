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
            '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
            '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
            '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
            '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
            '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
            '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',

            '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
        ];

        // === STEP 2: 各都道府県の「前髪崩壊スコア」を計算する ===
        $scores = [];
        foreach ($prefectures as $prefecture) {
            $weatherData = $weatherService->getCurrentWeather($prefecture);
            if ($weatherData) {
                $score = $weatherService->calculateFringeCollapseRate($weatherData);
                $scores[] = [
                    'prefecture' => $prefecture,
                    'score' => $score,
                ];
                $this->line("{$prefecture} のスコアを計算しました: {$score}");
            } else {
                $this->warn("{$prefecture} の天気情報が取得できませんでした。");
            }
            sleep(1); // APIへの連続リクエストを防ぐために1秒待機
        }

        // === STEP 3: 計算したスコアを、高い順に並び替える ===
        // PHPのusort関数を使って、'score'の値で降順（大きい順）にソート
        usort($scores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // === STEP 4: ランキングデータをデータベースに保存する ===
        $today = Carbon::today(); // 今日の日付を取得

        // まず、今日の古いランキングデータがあれば削除する
        Ranking::where('type', 'fringe_collapse')->where('ranking_date', $today)->delete();

        // 新しいランキングデータを保存
        foreach ($scores as $index => $data) {
            Ranking::create([
                'type' => 'fringe_collapse',
                'ranking_date' => $today,
                'prefecture' => $data['prefecture'],
                'score' => $data['score'],
                'rank' => $index + 1, // 順位は1から始まるため +1 する
            ]);
        }

        $this->info('ランキングの更新が完了しました！');
        return Command::SUCCESS;
    }
}