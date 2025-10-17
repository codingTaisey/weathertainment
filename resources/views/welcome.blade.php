<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weathertainment</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; background-color: #f4f4f9; color: #333; }
        .container { padding: 30px; border: 1px solid #ddd; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-block; }
        h1 { color: #5a5a5a; }
        h2 { border-bottom: 2px solid #5a5a5a; padding-bottom: 10px; }
        h3 { margin-top: 30px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        p { margin: 10px 0; }
        strong { font-size: 1.2em; color: #d9534f; }
        hr { border: none; border-top: 1px solid #eee; margin: 20px 0; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Weathertainment</h1>

        @if (isset($weatherData) && $weatherData)
            <h2>{{ $weatherData['name'] }} の今日の予報</h2>
            <p>天気: {{ $weatherData['weather'][0]['description'] }}</p>
            <p>気温: {{ $weatherData['main']['temp'] }} ℃</p>
            <p>湿度: {{ $weatherData['main']['humidity'] }} %</p>

            <hr>

            <h3>面白指数</h3>
            <p>今日のくしゃみ確率: <strong>{{ $sneezeRate }} %</strong></p>
            <p>前髪崩壊率: <strong>{{ $fringeCollapseRate }} %</strong></p>
            <p>傘忘れ後悔度: <strong>{{ $umbrellaRegretLevel }} %</strong></p>
            <p>猫が丸くなる確率: <strong>{{ $catCurlRate }} %</strong></p>
            <p>今日のダルさ言い訳予報: <strong>{{ $lazinessExcuseRate }} %</strong></p>

        @else
            <p class="error">天気情報の取得に失敗しました。APIキーの設定を確認してください。</p>
        @endif
    </div>

</body>
</html>