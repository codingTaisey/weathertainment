<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * 指定された都市の現在の天気データを取得する
     */
    public function getCurrentWeather(?string $city = null): ?array
    {
        // デフォルト値を設定
        if (!$city) {
            $city = 'Tokyo';
        }

        // 都道府県名を英語の都市名に変換
        $city = $this->convertPrefectureToCity($city);

        $apiKey = config('services.openweathermap.key');
        if (! $apiKey) {
            return null;
        }

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'ja',
        ]);

        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }

    /**
     * 天気データから「前髪崩壊率」を計算する
     */
    public function calculateFringeCollapseRate(array $weatherData): int
    {
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];
        $rate = ($humidity * 0.8) + ($windSpeed * 10);
        return min(100, max(0, (int)$rate));
    }


    /**
     * 天気データから「くしゃみ発生確率」を計算する
     * 【それっぽい計算式】湿度が低く、風が強いと確率が上がると仮定
     */
    public function calculateSneezeRate(array $weatherData): int
    {
        $humidity = $weatherData['main']['humidity'];
        $windSpeed = $weatherData['wind']['speed'];
        // 湿度が40%を切ると急激に上昇、風速も影響
        $rate = (100 - $humidity) * 1.5 + ($windSpeed * 5);
        return min(100, max(0, (int)$rate));
    }

    /**
     * 天気データから「傘忘れ後悔度」を計算する
     * 【それっぽい計算式】天気が「雨」なら確率が上がると仮定
     */
    public function calculateUmbrellaRegretLevel(array $weatherData): int
    {
        // 'Rain', 'Drizzle', 'Thunderstorm' などの場合に確率を高くする
        if (in_array($weatherData['weather'][0]['main'], ['Rain', 'Drizzle', 'Thunderstorm'])) {
            // 降水量(あれば)や風の強さで後悔度を増減させても面白い
            return rand(70, 100); // 70%〜100%の間でランダム
        }
        return rand(0, 20); // 0%〜20%の間でランダム
    }

    /**
     * 天気データから「猫が丸くなる確率」を計算する
     * 【それっぽい計算式】気温が低いほど丸くなると仮定
     */
    public function calculateCatCurlRate(array $weatherData): int
    {
        $temp = $weatherData['main']['temp'];
        // 15℃以下で確率が急上昇し、25℃以上ではほぼ丸くならないと仮定
        if ($temp < 15) {
            return 100 - ($temp * 2);
        } elseif ($temp > 25) {
            return 5;
        }
        return 60 - $temp;
    }

    /**
     * 天気データから「洗濯物カビリスク」を計算する
     * 【それっぽい計算式】湿度が高く、雨が降っているとカビリスクが上がると仮定
     */
    public function calculateLaundryMoldRisk(array $weatherData): int
    {
        $humidity = $weatherData['main']['humidity'];
        $weatherMain = $weatherData['weather'][0]['main'];

        // 雨系の天気の場合はリスクを高く設定
        $rainMultiplier = 1.0;
        if (in_array($weatherMain, ['Rain', 'Drizzle', 'Thunderstorm'])) {
            $rainMultiplier = 1.5;
        }

        // 湿度が高いほど、雨が降っているほどカビリスクが上昇
        $risk = ($humidity * 0.8) * $rainMultiplier;

        return min(100, max(0, (int)$risk));
    }

    /**
     * 天気データから「今日のダルさ言い訳予報」の確率を計算する
     * 【それっぽい計算式】気圧が低いほどダルいと仮定
     */
    public function getLazinessExcuse(array $weatherData): array
    {
        if (!isset($weatherData['main']['pressure'])) {
            return ['level' => '??', 'excuse' => '気圧データが取得できませんでした。', 'color' => 'gray'];
        }
        $pressure = $weatherData['main']['pressure'];

        // ★★★ 日本の気圧変動に合わせた、より敏感な閾値に調整 ★★★
        if ($pressure < 1000) {
            $level = 5;
            $excuse = '【言い訳】今日は記録的な低気圧です。ベッドから出られただけでも奇跡。業務効率は諦めましょう。';
            $color = '#e74c3c';
        } elseif ($pressure < 1005) { // 以前は1008
            $level = 4;
            $excuse = '【言い訳】「気圧のせいで頭が重い…」と言えば8割の人が許してくれます。たぶん。';
            $color = '#f39c12';
        } elseif ($pressure < 1010) { // 以前は1015
            $level = 3;
            $excuse = '【言い訳】なんとなくダルいのは気圧の仕業。コーヒーを淹れて、ゆっくり始動しましょう。';
            $color = '#f1c40f';
        } elseif ($pressure < 1015) { // 以前は1022
            $level = 2;
            $excuse = '【言い訳】体調はまずまずのはず。ダルいのは、もしかして気のせい…？';
            $color = '#2ecc71';
        } else {
            $level = 1;
            $excuse = '【言い訳】残念ながら、今日は快晴＆高気圧！ダルさの言い訳は通用しません。頑張りましょう！';
            $color = '#3498db';
        }

        return ['level' => $level, 'excuse' => $excuse, 'color' => $color];
    }

    /**
     * 都道府県名を英語の都市名に変換する
     */
    private function convertPrefectureToCity(string $prefecture): string
    {
        $prefectureMap = [
            '北海道' => 'Sapporo',
            '青森県' => 'Aomori',
            '岩手県' => 'Morioka',
            '宮城県' => 'Sendai',
            '秋田県' => 'Akita',
            '山形県' => 'Yamagata',
            '福島県' => 'Fukushima',
            '茨城県' => 'Mito',
            '栃木県' => 'Utsunomiya',
            '群馬県' => 'Maebashi',
            '埼玉県' => 'Saitama',
            '千葉県' => 'Chiba',
            '東京都' => 'Tokyo',
            '神奈川県' => 'Yokohama',
            '新潟県' => 'Niigata',
            '富山県' => 'Toyama',
            '石川県' => 'Kanazawa',
            '福井県' => 'Fukui',
            '山梨県' => 'Kofu',
            '長野県' => 'Nagano',
            '岐阜県' => 'Gifu',
            '静岡県' => 'Shizuoka',
            '愛知県' => 'Nagoya',
            '三重県' => 'Tsu',
            '滋賀県' => 'Otsu',
            '京都府' => 'Kyoto',
            '大阪府' => 'Osaka',
            '兵庫県' => 'Kobe',
            '奈良県' => 'Nara',
            '和歌山県' => 'Wakayama',
            '鳥取県' => 'Tottori',
            '島根県' => 'Matsue',
            '岡山県' => 'Okayama',
            '広島県' => 'Hiroshima',
            '山口県' => 'Yamaguchi',
            '徳島県' => 'Tokushima',
            '香川県' => 'Takamatsu',
            '愛媛県' => 'Matsuyama',
            '高知県' => 'Kochi',
            '福岡県' => 'Fukuoka',
            '佐賀県' => 'Saga',
            '長崎県' => 'Nagasaki',
            '熊本県' => 'Kumamoto',
            '大分県' => 'Oita',
            '宮崎県' => 'Miyazaki',
            '鹿児島県' => 'Kagoshima',
            '沖縄県' => 'Naha',
        ];

        return $prefectureMap[$prefecture] ?? 'Tokyo';
    }
}
