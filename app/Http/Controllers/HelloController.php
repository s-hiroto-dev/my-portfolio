<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
    // ここに処理を追加
    public function index()
    {
        return 'コントローラー経由：こんにちは2！未経験ポートフォリオ作成中';
    }
}
