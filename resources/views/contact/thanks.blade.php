@extends('layouts.parents')
@section('title', 'お問い合わせ完了')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item"><a href="{{ route('contact') }}">お問い合わせ</a></li>
      <li class="breadcrumb-item active" aria-current="page">完了</li>
    </ol>
  </nav>

  <div class="row mt-5">
    <div class="col-lg-8 mx-auto">
      <div class="card border-success">
        <div class="card-body text-center py-5">
          <div class="mb-4">
            <i class="fas fa-check-circle fa-5x text-success"></i>
          </div>
          <h3 class="card-title mb-4">お問い合わせを受け付けました</h3>
          <p class="lead mb-4">
            お問い合わせいただきありがとうございます。
          </p>
          <p class="text-muted">
            内容を確認の上、担当者よりご連絡させていただきます。<br>
            今しばらくお待ちくださいませ。
          </p>
          
          <div class="mt-5">
            <a href="{{ route('index') }}" class="btn btn-primary btn-lg mr-2">
              <i class="fas fa-home"></i> トップページへ
            </a>
            <a href="{{ route('goods_list') }}" class="btn btn-outline-primary btn-lg">
              <i class="fas fa-shopping-bag"></i> 商品一覧へ
            </a>
          </div>
        </div>
      </div>

      <div class="alert alert-info mt-4">
        <h6><i class="fas fa-info-circle"></i> 自動返信メールについて</h6>
        <p class="mb-0 small">
          お問い合わせ内容を記載した自動返信メールを送信しております。
          メールが届かない場合は、迷惑メールフォルダをご確認いただくか、
          お手数ですが再度お問い合わせください。
        </p>
      </div>
    </div>
  </div>
</div>
@endsection
