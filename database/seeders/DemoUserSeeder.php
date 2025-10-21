<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // デモユーザーが既に存在するかチェック
        if (User::where('email', 'demo@example.com')->exists()) {
            $this->command->info('デモユーザーは既に存在します。');
            return;
        }

        // デモユーザーを作成
        User::create([
            'name' => 'デモユーザー',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'prefecture' => '東京都',
        ]);

        $this->command->info('デモユーザーを作成しました。');
        $this->command->info('メールアドレス: demo@example.com');
        $this->command->info('パスワード: password');
    }
}
