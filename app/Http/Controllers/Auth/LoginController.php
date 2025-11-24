<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * ログインフォームを表示
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function login(Request $request)
    {
        // バリデーション
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 退会済みユーザーのチェック
        $user = \App\User::where('email', $request->email)->first();

        if ($user && $user->delete_flg == 1) {
            return redirect()->back()
                ->withErrors(['email' => 'このアカウントは退会済みです。'])
                ->withInput($request->only('email'));
        }

        // ログイン試行
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // ログイン成功
            $request->session()->regenerate();
            return redirect()->intended(route('index'))->with('success', 'ログインしました。');
        }

        // ログイン失敗
        return redirect()->back()
            ->withErrors(['email' => 'メールアドレスまたはパスワードが正しくありません。'])
            ->withInput($request->only('email'));
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'ログアウトしました。');
    }
}
