<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    /**
     * ゲスト用のトップページを表示する
     */
    public function home(WeatherService $weatherService)
    {
        // 天気取得と指数計算のロジック
        $viewData = $this->getWeatherData($weatherService);

        // homeビューを返す
        return view('home', $viewData);
    }

    /**
     * ログインユーザー用のダッシュボードを表示する
     */
    public function dashboard(WeatherService $weatherService)
    {
        // 天気取得と指数計算のロジック
        $viewData = $this->getWeatherData($weatherService);

        // dashboardビューを返す
        return view('dashboard', $viewData);
    }

    /**
     * 天気情報を取得し、ビューに渡すためのデータを生成する共通メソッド
     */
    private function getWeatherData(WeatherService $weatherService): array
    {
        // 将来的には、ログインユーザーの登録地域を使う
        $city = 'Tokyo';
        $weatherData = $weatherService->getCurrentWeather($city);

        if (!$weatherData) {
            return ['weatherData' => null];
        }

        $viewData = [
            'weatherData' => $weatherData,
            'fringeCollapseRate' => $weatherService->calculateFringeCollapseRate($weatherData),
            'sneezeRate' => $weatherService->calculateSneezeRate($weatherData),
            'umbrellaRegretLevel' => $weatherService->calculateUmbrellaRegretLevel($weatherData),
            'catCurlRate' => $weatherService->calculateCatCurlRate($weatherData),
            'lazinessExcuse' => $weatherService->getLazinessExcuse($weatherData),
        ];

        $shareText = "今日の{$city}のダルさ予報はLv.{$viewData['lazinessExcuse']['level']}でした！..."; // (以下略)
        $hashtags = 'Weathertainment,ダルさ言い訳予報';
        $appUrl = url('/');
        $viewData['twitterShareUrl'] = "https://twitter.com/intent/tweet?" . http_build_query(['text' => $shareText, 'url' => $appUrl, 'hashtags' => $hashtags]);

        return $viewData;
    }
}
