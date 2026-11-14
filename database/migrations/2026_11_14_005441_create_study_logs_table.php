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
        Schema::create('study_logs', function (Blueprint $table) {
            $table->id();

            // add
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // ユーザーID（ログインユーザーと紐付ける）
            $table->integer('duration_minutes'); // 就活に向き合った時間（分）
            $table->text('memo')->nullable(); // やったことのメモ（空欄でもOKにする場合はnullable）
            // --------------------

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_logs');
    }
};
