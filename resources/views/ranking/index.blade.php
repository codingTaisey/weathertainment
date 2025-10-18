<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>全国前髪崩壊ランキング - Weathertainment</title>
    <style>
        body { font-family: sans-serif; text-align: center; margin-top: 50px; background-color: #f4f4f9; color: #333; }
        .container { padding: 30px; border: 1px solid #ddd; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: inline-block; min-width: 400px; }
        h1 { color: #5a5a5a; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f8f8; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .rank-1 { font-weight: bold; color: #d9534f; } /* 1位 */
        .rank-2 { font-weight: bold; color: #f0ad4e; } /* 2位 */
        .rank-3 { font-weight: bold; color: #5bc0de; } /* 3位 */
        a { color: #0275d8; text-decoration: none; display: inline-block; margin-top: 20px;}
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <h1>全国前髪崩壊ランキング</h1>

        @if ($rankings->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>順位</th>
                        <th>都道府県</th>
                        <th>崩壊スコア</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankings as $ranking)
                        <tr class="rank-{{ $ranking->rank }}">
                            <td>{{ $ranking->rank }}位</td>
                            <td>{{ $ranking->prefecture }}</td>
                            <td>{{ $ranking->score }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>本日のランキングデータはまだ集計されていません。</p>
            <p>（`php artisan ranking:update` を実行してください）</p>
        @endif

        <a href="/">トップページに戻る</a>
    </div>

</body>
</html>