@extends('layouts.parents')
@section('title', 'このサイトについて')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item active" aria-current="page">About</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">About - このサイトについて</h3>

  <div class="row mt-4">
    <div class="col-lg-8 mx-auto">
      {{-- サイト紹介 --}}
      <section class="mb-5">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">
              <i class="fas fa-store text-danger"></i> SHOPPING SITEへようこそ
            </h4>
            <p class="lead text-center mb-4">
              私たちは、お客様に最高のショッピング体験を提供することを目指しています。
            </p>
            <p>
              SHOPPING SITEは、高品質な商品を手頃な価格でお届けするオンラインショッピングサイトです。
              厳選された商品ラインナップと、安心・安全なお買い物環境をご提供いたします。
            </p>
          </div>
        </div>
      </section>

      {{-- 特徴 --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-star text-warning"></i> 私たちの特徴
        </h4>
        <div class="row">
          <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <div class="text-center mb-3">
                  <i class="fas fa-shield-alt fa-3x text-primary"></i>
                </div>
                <h5 class="card-title text-center">安心・安全</h5>
                <p class="card-text">
                  SSL暗号化通信により、お客様の個人情報を厳重に保護しています。
                  安心してお買い物をお楽しみください。
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <div class="text-center mb-3">
                  <i class="fas fa-shipping-fast fa-3x text-success"></i>
                </div>
                <h5 class="card-title text-center">迅速な配送</h5>
                <p class="card-text">
                  ご注文いただいた商品は、最短で翌日にお届けします。
                  お急ぎの場合も安心です。
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <div class="text-center mb-3">
                  <i class="fas fa-headset fa-3x text-info"></i>
                </div>
                <h5 class="card-title text-center">充実のサポート</h5>
                <p class="card-text">
                  お客様からのご質問やお困りごとに、専任スタッフが丁寧に対応いたします。
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-body">
                <div class="text-center mb-3">
                  <i class="fas fa-tags fa-3x text-danger"></i>
                </div>
                <h5 class="card-title text-center">お得な価格</h5>
                <p class="card-text">
                  高品質な商品を、できる限りリーズナブルな価格でご提供することを心がけています。
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {{-- 会社情報 --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-building text-secondary"></i> 会社情報
        </h4>
        <div class="card">
          <div class="card-body">
            <table class="table table-borderless">
              <tr>
                <th style="width: 30%;">会社名</th>
                <td>株式会社SHOPPING SITE</td>
              </tr>
              <tr>
                <th>設立</th>
                <td>2024年</td>
              </tr>
              <tr>
                <th>所在地</th>
                <td>〒000-0000 東京都○○区○○ 1-2-3</td>
              </tr>
              <tr>
                <th>事業内容</th>
                <td>オンラインショッピングサイトの運営</td>
              </tr>
              <tr>
                <th>営業時間</th>
                <td>平日 10:00〜18:00（土日祝休み）</td>
              </tr>
            </table>
          </div>
        </div>
      </section>

      {{-- お問い合わせへのリンク --}}
      <section class="text-center mb-5">
        <div class="card bg-light">
          <div class="card-body">
            <h5 class="card-title">ご不明な点がございましたら</h5>
            <p class="card-text">お気軽にお問い合わせください</p>
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
              <i class="fas fa-envelope"></i> お問い合わせ
            </a>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
