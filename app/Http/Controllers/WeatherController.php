<?php

namespace App\Http\Controllers; // ← ここを修正

use Illuminate\Http\Request;      // ← ここを修正
use App\Services\WeatherService;  // ← ここを修正

class WeatherController extends Controller
{
    /**
     * トップページ or ダッシュボードに天気情報を表示する
     *
     * @param WeatherService $weatherService
     * @return \Illuminate\View\View
     */
    public function index(WeatherService $weatherService)
    {
        $city = request()->input('prefecture', '東京都');
        $weatherData = $weatherService->getCurrentWeather($city);

        // --- ビューに渡すための共通データをまとめる ---
        $viewData = [];
        if ($weatherData) {
            $viewData = [
                'weatherData' => $weatherData,
                'fringeCollapseRate' => $weatherService->calculateFringeCollapseRate($weatherData),
                'sneezeRate' => $weatherService->calculateSneezeRate($weatherData),
                'umbrellaRegretLevel' => $weatherService->calculateUmbrellaRegretLevel($weatherData),
                'catCurlRate' => $weatherService->calculateCatCurlRate($weatherData),
                'lazinessExcuse' => $weatherService->getLazinessExcuse($weatherData),
            ];

            // シェアテキストの生成
            $shareText = "今日の{$city}のダルさ予報はLv.{$viewData['lazinessExcuse']['level']}でした！\n「{$viewData['lazinessExcuse']['excuse']}」\n\nあなたもチェックしてみよう！";
            $hashtags = 'Weathertainment,ダルさ言い訳予報';
            $appUrl = url('/');

            $viewData['twitterShareUrl'] = "https://twitter.com/intent/tweet?" . http_build_query([
                'text' => $shareText,
                'url' => $appUrl,
                'hashtags' => $hashtags,
            ]);
        } else {
            // 天気取得失敗時のデータ
            $viewData['weatherData'] = null;
        }

        // ログイン状態に応じて、表示するビューを切り替える
        if (auth()->check()) {
            // ログイン済みユーザーには 'dashboard' ビューを返す
            return view('dashboard', $viewData);
        } else {
            // ゲストユーザーには 'home' ビューを返す
            return view('home', $viewData);
        }
    }
}