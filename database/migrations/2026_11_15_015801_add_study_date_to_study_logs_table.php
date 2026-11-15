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
        Schema::table('study_logs', function (Blueprint $table) {
            // 【追加】就活を行った日を保存するカラム（日付型: date）
            // 過去の記録も入れられるように、作成日時とは別に日付を持たす
            $table->date('study_date')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('study_logs', function (Blueprint $table) {
            // 【追加】ロールバック（元に戻す）したときにカラムを削除する設定
            $table->dropColumn('study_date');
        });
    }
};