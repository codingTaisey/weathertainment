<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class RankingController extends Controller
{
    /**
     * ランキングページを表示する
     */
    public function index(Request $request)
    {
        $today = Carbon::today();
        $selectedType = $request->get('type', 'sneeze'); // デフォルトはくしゃみ確率

        // 3種類のランキングデータを取得
        $rankings = [
            'sneeze' => Ranking::where('type', 'sneeze')
                ->where('ranking_date', $today)
                ->orderBy('rank', 'asc')
                ->get(),
            'fringe_collapse' => Ranking::where('type', 'fringe_collapse')
                ->where('ranking_date', $today)
                ->orderBy('rank', 'asc')
                ->get(),
            'laundry_mold' => Ranking::where('type', 'laundry_mold')
                ->where('ranking_date', $today)
                ->orderBy('rank', 'asc')
                ->get(),
        ];

        // 統計情報を計算
        $stats = $this->calculateStats($rankings[$selectedType], $today);

        // 週間推移データを取得（過去7日間）
        $weeklyData = $this->getWeeklyTrends($selectedType);

        return view('ranking.index', [
            'rankings' => $rankings,
            'selectedType' => $selectedType,
            'stats' => $stats,
            'weeklyData' => $weeklyData,
        ]);
    }

    /**
     * 手動でランキングを更新する
     */
    public function update()
    {
        try {
            Artisan::call('ranking:update');
            return redirect()->back()->with('success', 'ランキングを更新しました！');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ランキングの更新に失敗しました。');
        }
    }

    /**
     * 統計情報を計算する
     */
    private function calculateStats($rankings, $date)
    {
        if ($rankings->isEmpty()) {
            return [
                'updateDate' => $date->format('Y/m/d'),
                'prefectureCount' => 0,
                'averageScore' => 0,
            ];
        }

        return [
            'updateDate' => $date->format('Y/m/d'),
            'prefectureCount' => $rankings->count(),
            'averageScore' => round($rankings->avg('score'), 1),
        ];
    }

    /**
     * 週間推移データを取得する
     */
    private function getWeeklyTrends($type)
    {
        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subDays(6);

        $trends = [];
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $ranking = Ranking::where('type', $type)
                ->where('ranking_date', $date)
                ->orderBy('rank', 'asc')
                ->get();

            $trends[] = [
                'date' => $date->format('m/d'),
                'averageScore' => $ranking->isNotEmpty() ? round($ranking->avg('score'), 1) : 0,
                'topScore' => $ranking->isNotEmpty() ? $ranking->first()->score : 0,
            ];
        }

        return $trends;
    }
}
