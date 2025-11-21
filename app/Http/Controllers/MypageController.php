<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MypageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * マイページを表示
     */
    public function index()
    {
        // ログインしていない場合はログインページへリダイレクト
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'ログインが必要です。']);
        }

        return view('mypage.index');
    }
}
