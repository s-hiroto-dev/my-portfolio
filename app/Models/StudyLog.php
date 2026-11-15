<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyLog extends Model
{
    use HasFactory;

    // データベースに保存を許可するカラム（ホワイトリスト）
    protected $fillable = [
        'user_id',
        'duration_minutes',
        'memo',
        'study_date', // ここに日付入力日追加
    ];
}