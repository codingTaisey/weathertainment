<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            // ランキング検索の高速化のためのインデックス追加
            $table->index(['type', 'ranking_date'], 'rankings_type_date_index');
            $table->index('rank', 'rankings_rank_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropIndex('rankings_type_date_index');
            $table->dropIndex('rankings_rank_index');
        });
    }
};
