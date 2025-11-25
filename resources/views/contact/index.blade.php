@extends('layouts.parents')
@section('title', 'お問い合わせ')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Contact</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">Contact - お問い合わせ</h3>

  @if ($errors->any())
    <div class="alert alert-danger mt-3">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row mt-4">
    <div class="col-lg-8 mx-auto">
      <div class="card">
        <div class="card-body">
          <p class="text-muted mb-4">
            <i class="fas fa-info-circle"></i> 
            商品やサービスに関するご質問、ご意見、ご要望など、お気軽にお問い合わせください。
            内容を確認の上、担当者より折り返しご連絡させていただきます。
          </p>

          <form action="{{ route('contact_submit') }}" method="POST">
            @csrf

            {{-- お名前 --}}
            <div class="form-group">
              <label for="name">お名前 <span class="badge badge-danger">必須</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" 
                     id="name" name="name" value="{{ old('name') }}" 
                     placeholder="山田 太郎" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="form-group">
              <label for="email">メールアドレス <span class="badge badge-danger">必須</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" 
                     id="email" name="email" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" 
                     placeholder="example@example.com" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="form-text text-muted">
                回答をお送りするメールアドレスを入力してください
              </small>
            </div>

            {{-- 件名 --}}
            <div class="form-group">
              <label for="subject">件名 <span class="badge badge-danger">必須</span></label>
              <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                     id="subject" name="subject" value="{{ old('subject') }}" 
                     placeholder="商品について" required>
              @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- お問い合わせ内容 --}}
            <div class="form-group">
              <label for="message">お問い合わせ内容 <span class="badge badge-danger">必須</span></label>
              <textarea class="form-control @error('message') is-invalid @enderror" 
                        id="message" name="message" rows="8" 
                        placeholder="お問い合わせ内容を詳しくご記入ください" required>{{ old('message') }}</textarea>
              @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <small class="form-text text-muted">
                2000文字以内で入力してください
              </small>
            </div>

            {{-- 送信ボタン --}}
            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane"></i> 送信する
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- 注意事項 --}}
      <div class="alert alert-info mt-4">
        <h6><i class="fas fa-exclamation-circle"></i> ご注意</h6>
        <ul class="mb-0 small">
          <li>お問い合わせ内容によっては、回答までにお時間をいただく場合がございます</li>
          <li>営業時間外や休業日にいただいたお問い合わせは、翌営業日以降の対応となります</li>
          <li>内容によってはお答えできない場合もございますので、予めご了承ください</li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
