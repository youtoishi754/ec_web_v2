<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\PreRegistrationMail;
use App\User;

class PreRegistrationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function showForm()
    {
        return view('auth.pre_register');
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:users,email',
        ];

        $messages = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->input('email');
        $token = Str::random(64);

        // upsert into pre_registrations
        $existing = DB::table('pre_registrations')->where('email', $email)->first();
        if ($existing) {
            DB::table('pre_registrations')->where('email', $email)->update([
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('pre_registrations')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

          // メール送信
         Mail::to($request->email)->send(new PreRegistrationMail($token));

        // TODO: send confirmation email with token link

        return view('auth.pre_register_done', ['email' => $email]);
    }

    public function confirm($token)
    {
        // トークンで仮登録を検索
        $preRegistration = DB::table('pre_registrations')
            ->where('token', $token)
            ->first();
        
        // トークンが見つからない場合
        if (!$preRegistration) {

            return redirect()->route('pre_register')
                ->withErrors(['token' => '無効なトークンです。再度登録してください。']);
                
        }

        // トークンの有効期限チェック（例：24時間）
        $createdAt = new \DateTime($preRegistration->created_at);
        $now = new \DateTime();
        $diff = $now->diff($createdAt);
        $hours = ($diff->days * 24) + $diff->h;

        if ($hours > 24) {

            return redirect()->route('pre_register')
                ->withErrors(['token' => 'トークンの有効期限が切れています。再度登録してください。']);
        }


        // 本登録フォームを表示
        return view('auth.pre_register_confirm', [
            'email' => $preRegistration->email,
            'token' => $token
        ]);
    }

    public function complete(Request $request)
    {
        // バリデーション
        $rules = [
            'token' => 'required|string',
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
            'password' => 'required|string|min:8|confirmed',
        ];

        $messages = [
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
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワードが一致しません。',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // トークンで仮登録を検索
        $preRegistration = DB::table('pre_registrations')
            ->where('token', $request->token)
            ->first();

        if (!$preRegistration) {
            return redirect()->route('pre_register')
                ->withErrors(['token' => '無効なトークンです。再度登録してください。']);
        }

        // トークンの有効期限チェック（例：24時間）
        $createdAt = new \DateTime($preRegistration->created_at);
        $now = new \DateTime();
        $diff = $now->diff($createdAt);
        $hours = ($diff->days * 24) + $diff->h;

        if ($hours > 24) {
            return redirect()->route('pre_register')
                ->withErrors(['token' => 'トークンの有効期限が切れています。再度登録してください。']);
        }

        // ユーザー登録
        $user = User::create([
            'name' => $request->last_name . ' ' . $request->first_name,
            'email' => $preRegistration->email,
            'password' => Hash::make($request->password),
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'last_name_kana' => $request->last_name_kana,
            'first_name_kana' => $request->first_name_kana,
            'postal_code' => $request->postal_code,
            'prefecture' => $request->prefecture,
            'city' => $request->city,
            'address' => $request->address,
            'building' => $request->building,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'email_verified_at' => now(),
        ]);

        // 仮登録データを削除
        DB::table('pre_registrations')
            ->where('token', $request->token)
            ->delete();

        // ログイン
        auth()->login($user);

        // 完了画面へリダイレクト
        return redirect()->route('index')->with('success', '本登録が完了しました。');
    }
}
