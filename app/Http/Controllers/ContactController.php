<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends BaseController
{
    /**
     * お問い合わせフォームを表示
     */
    public function index()
    {
        return view('contact.index');
    }
    
    /**
     * お問い合わせ送信処理
     */
    public function submit(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'お名前を入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しいメールアドレス形式で入力してください',
            'subject.required' => '件名を入力してください',
            'message.required' => 'お問い合わせ内容を入力してください',
            'message.max' => 'お問い合わせ内容は2000文字以内で入力してください',
        ]);
        
        // セッションにデータを保存
        session()->put('contact_data', $validatedData);
        
        // 完了ページにリダイレクト
        return redirect()->route('contact_thanks')->with('success', 'お問い合わせを受け付けました。');
    }
    
    /**
     * お問い合わせ完了ページを表示
     */
    public function thanks()
    {
        // セッションからデータを取得
        $contactData = session()->get('contact_data');
        
        // セッションデータがない場合はフォームにリダイレクト
        if (!$contactData) {
            return redirect()->route('contact');
        }
        
        // セッションデータをクリア
        session()->forget('contact_data');
        
        return view('contact.thanks');
    }
}
