<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DemoLoginController extends Controller
{
    /**
     * デモユーザーでログインする
     */
    public function login()
    {
        // デモユーザーを取得または作成
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'デモユーザー',
                'password' => Hash::make('password'),
                'prefecture' => '東京都',
            ]
        );

        // デモユーザーでログイン
        Auth::login($demoUser);

        return redirect()->route('dashboard')->with('success', 'デモアカウントでログインしました！');
    }
}
