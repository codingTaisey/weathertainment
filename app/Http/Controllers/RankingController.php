<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking; // Rankingモデルをインポート
use Carbon\Carbon;       // Carbonをインポート

class RankingController extends Controller
{
    /**
     * ランキングページを表示する
     */
    public function index()
    {
        // 今日の日付を取得
        $today = Carbon::today();

        // 今日の「前髪崩壊」ランキングデータを、rankの昇順（1位から）で取得する
        $rankings = Ranking::where('type', 'fringe_collapse')
                            ->where('ranking_date', $today)
                            ->orderBy('rank', 'asc')
                            ->get();

        // 取得したランキングデータをビューに渡す
        return view('ranking.index', [
            'rankings' => $rankings
        ]);
    }
}