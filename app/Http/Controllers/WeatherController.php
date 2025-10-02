<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService; // WeatherServiceを使うための宣言

class WeatherController extends Controller
{
    /**
     * トップページを表示し、天気情報をビューに渡す
     *
     * @param WeatherService $weatherService Laravelが自動的にインスタンスを注入してくれる
     * @return \Illuminate\View\View
     */
    public function index(WeatherService $weatherService)
    {
        // とりあえず都市名を'Tokyo'で固定
        $city = 'Tokyo';

        // WeatherServiceのgetCurrentWeatherメソッドを呼び出す
        $weatherData = $weatherService->getCurrentWeather($city);

        // デバッグ用：ここで一旦、取得したデータの中身を見てみる
        // dd($weatherData);

        // weatherDataという名前で、ビューに天気情報を渡す
        return view('welcome', [
            'weatherData' => $weatherData
        ]);
    }
}