<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;     
use App\Services\WeatherService; 
class WeatherController extends Controller
{
    /**
     * トップページを表示し、天気情報と各指数、シェア用URLをビューに渡す
     *
     * @param WeatherService $weatherService
     * @return \Illuminate\View\View
     */
    public function index(WeatherService $weatherService)
    {
        $city = 'Tokyo';
        $weatherData = $weatherService->getCurrentWeather($city);

        if (!$weatherData) {
            return view('welcome', ['weatherData' => null]);
        }

        // 各指数を計算
        $fringeCollapseRate = $weatherService->calculateFringeCollapseRate($weatherData);
        $sneezeRate = $weatherService->calculateSneezeRate($weatherData);
        $umbrellaRegretLevel = $weatherService->calculateUmbrellaRegretLevel($weatherData);
        $catCurlRate = $weatherService->calculateCatCurlRate($weatherData);
        
        // 新しい「ダルさ言い訳」メソッドを呼び出す
        $lazinessExcuse = $weatherService->getLazinessExcuse($weatherData);


        // --- シェア用URL生成ロジック ---
        $shareText = "今日の{$city}のダルさ予報はLv.{$lazinessExcuse['level']}でした！\n「{$lazinessExcuse['excuse']}」\n\nあなたもチェックしてみよう！";
        $hashtags = 'Weathertainment,ダルさ言い訳予報';
        $appUrl = url('/');

        $twitterShareUrl = "https://twitter.com/intent/tweet?" . http_build_query([
            'text' => $shareText,
            'url' => $appUrl,
            'hashtags' => $hashtags,
        ]);
        // --- シェア用URL生成ロジックここまで ---

        // 計算結果とシェア用URLをまとめてビューに渡す
        return view('welcome', compact(
            'weatherData',
            'fringeCollapseRate',
            'sneezeRate',
            'umbrellaRegretLevel',
            'catCurlRate',
            'lazinessExcuse',
            'twitterShareUrl'
        ));
    }
}