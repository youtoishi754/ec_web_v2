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

        // ユーザーを論理削除（delete_flgを1に設定）
        $user->delete_flg = 1;
        $user->save();

        // セッションをクリア
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', '退会処理が完了しました。ご利用ありがとうございました。');
    }

    /**
     * プロフィール更新処理
     */
    public function updateProfile(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'last_name_kana' => 'required|string|max:50|regex:/^[ァ-ヶー]+$/u',
            'first_name_kana' => 'required|string|max:50|regex:/^[ァ-ヶー]+$/u',
            'postal_code' => 'required|string|regex:/^\d{3}-?\d{4}$/',
            'prefecture' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'building' => 'nullable|string|max:100',
            'phone' => 'required|string|regex:/^0\d{9,10}$/',
            'birthday' => 'nullable|date|before:today',
            'gender' => 'nullable|integer|in:0,1,2',
        ], [
            'last_name.required' => '姓を入力してください。',
            'first_name.required' => '名を入力してください。',
            'last_name_kana.required' => '姓（カナ）を入力してください。',
            'last_name_kana.regex' => '姓（カナ）は全角カタカナで入力してください。',
            'first_name_kana.required' => '名（カナ）を入力してください。',
            'first_name_kana.regex' => '名（カナ）は全角カタカナで入力してください。',
            'postal_code.required' => '郵便番号を入力してください。',
            'postal_code.regex' => '郵便番号は7桁の数字で入力してください。',
            'prefecture.required' => '都道府県を選択してください。',
            'city.required' => '市区町村を入力してください。',
            'address.required' => '番地を入力してください。',
            'phone.required' => '電話番号を入力してください。',
            'phone.regex' => '電話番号は10桁または11桁の数字で入力してください。',
            'birthday.date' => '有効な日付を入力してください。',
            'birthday.before' => '生年月日は今日より前の日付を入力してください。',
        ]);

        if ($validator->fails()) {
            return redirect()->route('mypage')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // プロフィールを更新
        $user->name = $request->last_name . ' ' . $request->first_name;
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->last_name_kana = $request->last_name_kana;
        $user->first_name_kana = $request->first_name_kana;
        $user->postal_code = $request->postal_code;
        $user->prefecture = $request->prefecture;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->gender = $request->gender;
        $user->save();

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');
    }
}
