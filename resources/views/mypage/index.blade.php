@extends('layouts.parents')
@section('title', 'マイページ')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item active" aria-current="page">マイページ</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">マイページ</h3>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="row mt-4">
    {{-- ユーザー情報カード --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-user"></i> ユーザー情報</h5>
        </div>
        <div class="card-body">
          <table class="table table-borderless">
            <tr>
              <th style="width: 30%;">名前</th>
              <td>{{ auth()->user()->name }}</td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td>{{ auth()->user()->email }}</td>
            </tr>
            <tr>
              <th>会員登録日</th>
              <td>{{ auth()->user()->created_at->format('Y年m月d日') }}</td>
            </tr>
            <tr>
              <th>メール認証</th>
              <td>
                @if(auth()->user()->email_verified_at)
                  <span class="badge badge-success">認証済み</span>
                @else
                  <span class="badge badge-warning">未認証</span>
                @endif
              </td>
            </tr>
          </table>
          <a href="#" class="btn btn-outline-primary btn-block" onclick="alert('プロフィール編集機能は未実装です'); return false;">
            <i class="fas fa-edit"></i> プロフィール編集（未実装）
          </a>
        </div>
      </div>
    </div>

    {{-- 注文履歴カード --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> 注文履歴</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">注文履歴機能は未実装です。</p>
          <button class="btn btn-outline-success btn-block" disabled>
            <i class="fas fa-list"></i> 注文履歴を見る（未実装）
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- お気に入りカード --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-warning text-white">
          <h5 class="mb-0"><i class="fas fa-heart"></i> お気に入り</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">お気に入り機能は未実装です。</p>
          <button class="btn btn-outline-warning btn-block" disabled>
            <i class="fas fa-star"></i> お気に入りを見る（未実装）
          </button>
        </div>
      </div>
    </div>

    {{-- 住所・配送先カード --}}
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> 配送先情報</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">配送先管理機能は未実装です。</p>
          <button class="btn btn-outline-info btn-block" disabled>
            <i class="fas fa-address-book"></i> 配送先を管理（未実装）
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h5 class="mb-0"><i class="fas fa-cog"></i> アカウント設定</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 mb-2">
              <button class="btn btn-outline-secondary btn-block" onclick="alert('パスワード変更機能は未実装です'); return false;">
                <i class="fas fa-key"></i> パスワード変更（未実装）
              </button>
            </div>
            <div class="col-md-4 mb-2">
              <button class="btn btn-outline-secondary btn-block" onclick="alert('メール変更機能は未実装です'); return false;">
                <i class="fas fa-envelope"></i> メールアドレス変更（未実装）
              </button>
            </div>
            <div class="col-md-4 mb-2">
              <button class="btn btn-outline-danger btn-block" onclick="alert('退会機能は未実装です'); return false;">
                <i class="fas fa-user-times"></i> 退会する（未実装）
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4 text-center">
    <a href="{{ route('goods_list') }}" class="btn btn-primary btn-lg">
      <i class="fas fa-shopping-cart"></i> 商品一覧へ
    </a>
  </div>
</div>
@endsection
