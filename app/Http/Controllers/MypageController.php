<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    /**
     * パスワード変更処理
     */
    public function updatePassword(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => '現在のパスワードを入力してください。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.min' => '新しいパスワードは8文字以上で入力してください。',
            'new_password.confirmed' => '新しいパスワードが一致しません。',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mypage')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // 現在のパスワードが正しいか確認
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('mypage')->withErrors(['current_password' => '現在のパスワードが正しくありません。']);
        }

        // 新しいパスワードが現在のパスワードと同じでないか確認
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->route('mypage')->withErrors(['new_password' => '新しいパスワードは現在のパスワードと異なるものを設定してください。']);
        }

        // パスワードを更新
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('mypage')->with('success', 'パスワードを変更しました。');
    }

    /**
     * メールアドレス変更処理
     */
    public function updateEmail(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'required',
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードを入力してください。',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mypage')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // パスワードが正しいか確認
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('mypage')->withErrors(['password' => 'パスワードが正しくありません。']);
        }

        // 現在のメールアドレスと同じでないか確認
        if ($user->email === $request->email) {
            return redirect()->route('mypage')->withErrors(['email' => '現在のメールアドレスと同じです。']);
        }

        // メールアドレスを更新
        $user->email = $request->email;
        $user->email_verified_at = null; // メール確認をリセット
        $user->save();

        return redirect()->route('mypage')->with('success', 'メールアドレスを変更しました。');
    }

    /**
     * 退会処理
     */
    public function delete(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm' => 'required|in:退会する',
        ], [
            'password.required' => 'パスワードを入力してください。',
            'confirm.required' => '「退会する」と入力してください。',
            'confirm.in' => '「退会する」と正確に入力してください。',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mypage')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // パスワードが正しいか確認
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('mypage')->withErrors(['password' => 'パスワードが正しくありません。']);
        }

        // ログアウト
        Auth::logout();

        // ユーザーを削除
        $user->delete();

        // セッションをクリア
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', '退会処理が完了しました。ご利用ありがとうございました。');
    }
}
