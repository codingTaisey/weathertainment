<?php

// このファイルがどの「住所」に属しているかを宣言しています。
// これにより、Laravelは正しくこのファイルを見つけることができます。
namespace App\Http\Controllers;

// これからこのファイルの中で使う「道具」を、あらかじめ読み込むための宣言です。
use App\Services\WeatherService; // 天気予報の専門家であるWeatherServiceクラスを使いますよ、という宣言。

// Laravelの基本的なコントローラが持つべき機能をすべて受け継いだ（extends）、
// 私たちのプロジェクト専用のWeatherControllerクラスを定義します。
class WeatherController extends Controller
{
    /**
     * トップページ("/")にアクセスが来たときに、メインの処理を担当するメソッドです。
     *
     * @param WeatherService $weatherService Laravelが自動的に用意してくれる天気予報の専門家
     * @return \Illuminate\View\View         ユーザーのブラウザに表示するHTML画面を返す
     */
    public function index(WeatherService $weatherService)
    {
        // === STEP 1: 準備 ===
        // ひとまず、天気情報を取得する都市を'Tokyo'という文字列で変数に格納します。
        // 将来的には、ユーザーが入力した都市名が入るようになります。
        $city = 'Tokyo';

        // === STEP 2: 専門家（WeatherService）への依頼 ===
        // ここが魔法の部分です！引数で受け取った$weatherService（天気予報の専門家）に、
        // 「getCurrentWeatherメソッドを使って、東京の天気情報を取ってきてください」と依頼します。
        // その結果（APIから返ってきた天気情報の配列）を、$weatherDataという変数に格納します。
        $weatherData = $weatherService->getCurrentWeather($city);

        // === STEP 3: エラーチェック（もしもの時のための保険） ===
        // もし、APIキーが間違っているなどの理由で$weatherDataがnull（取得失敗）だった場合、
        // 処理をここで中断し、エラーメッセージを表示するために、$weatherDataがnullのままビューに渡します。
        if (!$weatherData) {
            return view('welcome', ['weatherData' => null]);
        }

        // === STEP 4: 指数の計算依頼 ===
        // 無事に天気情報が取得できたら、その$weatherDataを材料にして、
        // 専門家（$weatherService）に各面白指数の計算を次々と依頼していきます。
        $fringeCollapseRate = $weatherService->calculateFringeCollapseRate($weatherData);
        $sneezeRate = $weatherService->calculateSneezeRate($weatherData);
        $umbrellaRegretLevel = $weatherService->calculateUmbrellaRegretLevel($weatherData);
        $catCurlRate = $weatherService->calculateCatCurlRate($weatherData);
        $lazinessExcuseRate = $weatherService->calculateLazinessExcuseRate($weatherData);

        // === STEP 5: 全ての計算結果をビュー（HTML）に渡す ===
        // 最後に、'welcome'という名前のビュー（resources/views/welcome.blade.php）を呼び出します。
        // その際、compact関数を使って、これまで準備した全てのデータ（天気情報＋５つの指数）を
        // ビューファイルに「変数」として渡します。
        // これにより、HTML側で {{ $fringeCollapseRate }} のようにして値を表示できるようになります。
        return view('welcome', compact(
            'weatherData',
            'fringeCollapseRate',
            'sneezeRate',
            'umbrellaRegretLevel',
            'catCurlRate',
            'lazinessExcuseRate'
        ));
    }
}