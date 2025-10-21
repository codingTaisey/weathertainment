<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Auth;

class WeatherController extends Controller
{
    public function index(WeatherService $weatherService)
    {
        // パーソナライズ表示機能: ログインユーザーは登録都道府県をデフォルト表示
        $defaultCity = '東京都';
        if (Auth::check() && Auth::user()->prefecture) {
            $defaultCity = Auth::user()->prefecture;
        }
        $city = request()->input('prefecture', $defaultCity);
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
                'laundryMoldRisk' => $weatherService->calculateLaundryMoldRisk($weatherData),
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
        // ★★★ このif文の書き方を修正 ★★★
        if (Auth::check()) {
            // ログイン済みユーザーには 'dashboard' ビューを返す
            return view('dashboard', $viewData);
        } else {
            // ゲストユーザーには 'home' ビューを返す
            return view('home', $viewData);
        }
    }
}
