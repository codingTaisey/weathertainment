<?php

// このファイルが「App\Services」という名前の空間に属することを宣言
namespace App\Services;

// LaravelのHTTPクライアントという道具を使えるようにする
use Illuminate\Support\Facades\Http;

// WeatherServiceという名前のクラス（設計図）を定義
class WeatherService
{
    /**
     * 指定された都市の現在の天気データを取得する
     *
     * @param string $city 都市名 (例: 'Tokyo')
     * @return array|null 天気データ、またはエラーの場合はnull
     */
    public function getCurrentWeather(string $city = 'Tokyo'): ?array
    {
        // config/services.phpからAPIキーを安全に取得
        $apiKey = config('services.openweathermap.key');

        // もしAPIキーが設定されていなければ、処理を中断
        if (! $apiKey) {
            return null;
        }

        // OpenWeatherMap APIにリクエストを送信
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric', // 温度を摂氏（℃）で取得するための設定
            'lang' => 'ja',      // 天気概要を日本語で取得するための設定
        ]);

        // レスポンスが成功した場合のみ、JSONデータをPHPの配列に変換して返す
        if ($response->successful()) {
            return $response->json();
        }

        // 失敗した場合はnullを返す
        return null;
    }
}