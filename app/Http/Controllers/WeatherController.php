<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Auth;

class WeatherController extends Controller
{
    public function index(WeatherService $weatherService)
{
    // === STEP 1: 表示する都市名を決定するロジック ===
    
    // まず、地域選択フォームからの入力を最優先でチェック
    $cityFromRequest = request()->input('prefecture');

    if ($cityFromRequest) {
        // フォームからの入力があれば、それを$cityとする
        $city = $cityFromRequest;
    } elseif (Auth::check() && Auth::user()->prefecture) {
        // フォーム入力がなく、ログインしていて、かつ都道府県が登録されていれば、それを使う
        $city = Auth::user()->prefecture;
    } else {
        // 上記のいずれでもなければ、デフォルトで'東京都'を使う
        $city = '東京都';
    }

    // === STEP 2: 天気情報を取得 ===
    $weatherData = $weatherService->getCurrentWeather($city);

    // --- ビューに渡すための共通データをまとめる ---
    $viewData = [];
    if ($weatherData) {
        $viewData = [
            'weatherData' => $weatherData,
            'selectedCity' => $city, // ★★★★★ 選択された都市名をビューに渡す！ ★★★★★
            'fringeCollapseRate' => $weatherService->calculateFringeCollapseRate($weatherData),
            'sneezeRate' => $weatherService->calculateSneezeRate($weatherData),
            'umbrellaRegretLevel' => $weatherService->calculateUmbrellaRegretLevel($weatherData),
            'catCurlRate' => $weatherService->calculateCatCurlRate($weatherData),
            'laundryMoldRisk' => $weatherService->calculateLaundryMoldRisk($weatherData),
            'lazinessExcuse' => $weatherService->getLazinessExcuse($weatherData),
        ];

        // シェアテキストの生成
        $shareText = "今日の{$city}のダルさ予報はLv.{$viewData['lazinessExcuse']['level']}でした！..."; // (以下略)
        $hashtags = 'Weathertainment,ダルさ言い訳予報';
        $appUrl = url('/');
        $viewData['twitterShareUrl'] = "https://twitter.com/intent/tweet?" . http_build_query([
            'text' => $shareText,
            'hashtags' => $hashtags,
            'url' => $appUrl
        ]);

    } else {
        // 天気取得失敗時のデータ
        $viewData['weatherData'] = null;
        $viewData['selectedCity'] = $city; // 失敗時も選択された都市名は渡す
    }

    // ログイン状態に応じて、表示するビューを切り替える
    if (Auth::check()) {
        return view('dashboard', $viewData);
    } else {
        return view('home', $viewData);
    }
}
}
