<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/..._create_rankings_table.php の up メソッド

public function up(): void
{
    Schema::create('rankings', function (Blueprint $table) {
        $table->id(); // ユニークなID
        $table->string('type'); // ランキングの種類 ('fringe_collapse', 'sneeze' など)
        $table->date('ranking_date'); // ランキングの集計日
        $table->string('prefecture'); // 都道府県名
        $table->integer('score'); // 計算されたスコア
        $table->integer('rank'); // その日の順位
        $table->timestamps(); // created_at と updated_at
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
