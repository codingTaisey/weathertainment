<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weathertainment</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; }
        .container { padding: 20px; border: 1px solid #ccc; display: inline-block; }
        h1 { color: #333; }
        .error { color: red; }
    </style>
</head>
<body>

    <div class="container">
        <h1>Weathertainment</h1>

        {{-- コントローラから$weatherDataが渡されているかチェック --}}
        @if (isset($weatherData))

            {{-- APIからのデータ取得に成功したかチェック --}}
            @if ($weatherData)
                <h2>{{ $weatherData['name'] }} の現在の天気</h2>
                <p>天気: {{ $weatherData['weather'][0]['description'] }}</p>
                <p>気温: {{ $weatherData['main']['temp'] }} ℃</p>
                <p>湿度: {{ $weatherData['main']['humidity'] }} %</p>
            @else
                <p class="error">天気情報の取得に失敗しました。APIキーの設定を確認してください。</p>
            @endif

        @else
            <p class="error">コントローラから天気データが渡されていません。</p>
        @endif
    </div>

</body>
</html>