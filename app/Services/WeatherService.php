<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    /**
     * 指定された都市の現在の天気データを取得する
     */
    public function getCurrentWeather(string $city = 'Tokyo'): ?array
    {
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

    // ↓↓↓↓ ここから4つのメソッドを新しく追加しました！ ↓↓↓↓

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
     * 天気データから「今日のダルさ言い訳予報」の確率を計算する
     * 【それっぽい計算式】気圧が低いほどダルいと仮定
     */
    public function getLazinessExcuse(array $weatherData): array
    {
        $pressure = $weatherData['main']['pressure'];

        if ($pressure < 1000) {
            return [
                'level' => 5,
                'excuse' => '【言い訳】今日は記録的な低気圧です。ベッドから出られただけでも奇跡。業務効率は諦めましょう。',
                'color' => 'red',
            ];
        } elseif ($pressure < 1010) {
            return [
                'level' => 4,
                'excuse' => '【言い訳】「気圧のせいで頭が重い…」と言えば8割の人が許してくれます。たぶん。',
                'color' => 'orange',
            ];
        } elseif ($pressure < 1015) {
            return [
                'level' => 3,
                'excuse' => '【言い訳】なんとなくダルいのは気圧の仕業。コーヒーを淹れて、ゆっくり始動しましょう。',
                'color' => 'gold',
            ];
        } else {
            return [
                'level' => 1,
                'excuse' => '【言い訳】残念ながら、今日は快晴！ダルさの言い訳は通用しません。頑張りましょう！',
                'color' => 'green',
            ];
        }
    }
}
