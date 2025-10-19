<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weathertainment</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #5a5a5a;
            margin-top: 0;
        }

        h2 {
            border-bottom: 2px solid #5a5a5a;
            padding-bottom: 10px;
        }

        h3 {
            margin-top: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            text-align: left;
        }

        p {
            margin: 12px 0;
            text-align: left;
            font-size: 1.1em;
        }

        strong {
            font-size: 1.2em;
            color: #d9534f;
            float: right;
        }

        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 30px 0;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* float解除用 */

        .links-container {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .share-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            /* アイコンとテキストの間隔 */
            padding: 10px 20px;
            border-radius: 9999px;
            /* 角を完全に丸くする */
            background-color: #14171A;
            /* Xの黒色 */
            color: white;
            font-size: 1em;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.2s, transform 0.2s;
        }

        .share-button:hover {
            background-color: #272c30;
            transform: translateY(-2px);
            /* 少し浮き上がる効果 */
        }

        .share-button svg {
            width: 20px;
            height: 20px;
        }

        .ranking-link {
            color: #0275d8;
            text-decoration: none;
            font-size: 1.1em;
        }

        .ranking-link:hover {
            text-decoration: underline;
        }

        .excuse-text {
            font-size: 0.9em;
            text-align: center;
            margin-top: 5px;
            padding: 0 10px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Weathertainment</h1>

        @if (isset($weatherData) && $weatherData)
        <h2>{{ $weatherData['name'] }} の今日の予報</h2>
        <div class="clearfix">
            <p>天気: <strong>{{ $weatherData['weather'][0]['description'] }}</strong></p>
        </div>
        <div class="clearfix">
            <p>気温: <strong>{{ $weatherData['main']['temp'] }} ℃</strong></p>
        </div>
        <div class="clearfix">
            <p>湿度: <strong>{{ $weatherData['main']['humidity'] }} %</strong></p>
        </div>

        <hr>

        <h3>面白指数</h3>
        <div class="clearfix">
            <p>今日のくしゃみ確率: <strong>{{ $sneezeRate }} %</strong></p>
        </div>
        <div class="clearfix">
            <p>前髪崩壊率: <strong>{{ $fringeCollapseRate }} %</strong></p>
        </div>
        <div class="clearfix">
            <p>傘忘れ後悔度: <strong>{{ $umbrellaRegretLevel }} %</strong></p>
        </div>
        <div class="clearfix">
            <p>猫が丸くなる確率: <strong>{{ $catCurlRate }} %</strong></p>
        </div>

        {{-- 「ダルさ言い訳予報」の表示 --}}
        <div class="clearfix">
            <p>今日のダルさ予報: <strong style="color: {{ $lazinessExcuse['color'] }};">Lv. {{ $lazinessExcuse['level'] }}</strong></p>
        </div>
        <p class="excuse-text">{{ $lazinessExcuse['excuse'] }}</p>

        <div class="links-container">
            <a href="{{ $twitterShareUrl }}" target="_blank" class="share-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 1227" fill="white">
                    <path d="M714.163 519.284L1160.89 0H1055.03L667.137 450.887L357.328 0H0L468.492 681.821L0 1226.37H105.866L515.491 750.218L842.672 1226.37H1200L714.137 519.284H714.163ZM569.165 687.828L521.697 619.924L144.011 79.6904H306.615L611.412 515.685L658.88 583.589L1058.01 1154.97H895.408L569.165 687.854V687.828Z" />
                </svg>
                結果をXでシェアする
            </a>
            <a href="/ranking" class="ranking-link">ランキングを見る</a>
        </div>

        @else
        <p class="error">天気情報の取得に失敗しました。APIキーの設定を確認してください。</p>
        @endif
    </div>

</body>

</html>