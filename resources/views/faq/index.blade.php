@extends('layouts.parents')
@section('title', 'よくある質問')
@section('content')
<div class="container">
  <nav aria-label="パンくずリスト">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('index') }}">トップ</a></li>
      <li class="breadcrumb-item active" aria-current="page">FAQ</li>
    </ol>
  </nav>

  <h3 style="border-bottom: 1px solid #000;border-left: 10px solid #000;padding: 7px;">FAQ - よくある質問</h3>

  <div class="row mt-4">
    <div class="col-lg-10 mx-auto">
      <p class="lead text-center mb-5">
        お客様からよくいただくご質問をまとめました。<br>
        こちらで解決しない場合は、<a href="{{ route('contact') }}">お問い合わせ</a>ください。
      </p>

      {{-- 会員登録について --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-user-plus text-primary"></i> 会員登録について
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq1">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none" type="button" data-toggle="collapse" data-target="#collapse1">
                <i class="fas fa-question-circle text-info"></i> 会員登録は必要ですか？
              </button>
            </h6>
          </div>
          <div id="collapse1" class="collapse show">
            <div class="card-body">
              会員登録をしていただくと、お買い物がよりスムーズになります。
              住所やお支払い情報を保存できるほか、注文履歴の確認やお気に入り商品の登録も可能です。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq2">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse2">
                <i class="fas fa-question-circle text-info"></i> 会員登録は無料ですか？
              </button>
            </h6>
          </div>
          <div id="collapse2" class="collapse">
            <div class="card-body">
              はい、会員登録は無料です。登録料や年会費などは一切かかりません。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq3">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse3">
                <i class="fas fa-question-circle text-info"></i> パスワードを忘れてしまいました
              </button>
            </h6>
          </div>
          <div id="collapse3" class="collapse">
            <div class="card-body">
              ログイン画面の「パスワードをお忘れの方」リンクから、パスワード再設定の手続きを行ってください。
              登録されているメールアドレスに再設定用のリンクをお送りします。
            </div>
          </div>
        </div>
      </section>

      {{-- 注文について --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-shopping-cart text-success"></i> 注文について
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq4">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse4">
                <i class="fas fa-question-circle text-info"></i> 注文のキャンセルはできますか？
              </button>
            </h6>
          </div>
          <div id="collapse4" class="collapse">
            <div class="card-body">
              商品の発送前であれば、キャンセルが可能です。
              発送後のキャンセルはお受けできませんので、ご了承ください。
              キャンセルをご希望の場合は、お早めに<a href="{{ route('contact') }}">お問い合わせ</a>ください。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq5">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse5">
                <i class="fas fa-question-circle text-info"></i> 注文内容の変更はできますか？
              </button>
            </h6>
          </div>
          <div id="collapse5" class="collapse">
            <div class="card-body">
              商品の発送前であれば、数量や配送先住所の変更が可能です。
              お早めに<a href="{{ route('contact') }}">お問い合わせ</a>ください。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq6">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse6">
                <i class="fas fa-question-circle text-info"></i> 領収書は発行できますか？
              </button>
            </h6>
          </div>
          <div id="collapse6" class="collapse">
            <div class="card-body">
              はい、領収書の発行が可能です。
              ご注文時の備考欄に「領収書希望」とご記入いただくか、
              <a href="{{ route('contact') }}">お問い合わせ</a>よりご依頼ください。
            </div>
          </div>
        </div>
      </section>

      {{-- 配送について --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-truck text-warning"></i> 配送について
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq7">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse7">
                <i class="fas fa-question-circle text-info"></i> 送料はいくらですか？
              </button>
            </h6>
          </div>
          <div id="collapse7" class="collapse">
            <div class="card-body">
              配送先の地域や商品の大きさによって異なります。
              カート画面で正確な送料をご確認いただけます。
              一定金額以上のご注文で送料無料になるキャンペーンも実施しております。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq8">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse8">
                <i class="fas fa-question-circle text-info"></i> 配送にかかる日数は？
              </button>
            </h6>
          </div>
          <div id="collapse8" class="collapse">
            <div class="card-body">
              通常、ご注文から3〜5営業日でお届けします。
              地域や在庫状況によって前後する場合がありますので、ご了承ください。
              お急ぎの場合は、お問い合わせください。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq9">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse9">
                <i class="fas fa-question-circle text-info"></i> 配送状況を確認できますか？
              </button>
            </h6>
          </div>
          <div id="collapse9" class="collapse">
            <div class="card-body">
              商品発送後、マイページの注文履歴から追跡番号をご確認いただけます。
              追跡番号を使って、配送業者のサイトで配送状況を確認できます。
            </div>
          </div>
        </div>
      </section>

      {{-- 支払いについて --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-credit-card text-danger"></i> お支払いについて
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq10">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse10">
                <i class="fas fa-question-circle text-info"></i> どのような支払い方法がありますか？
              </button>
            </h6>
          </div>
          <div id="collapse10" class="collapse">
            <div class="card-body">
              クレジットカード、銀行振込、代金引換、コンビニ決済がご利用いただけます。
              （※現在、決済機能は未実装です）
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq11">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse11">
                <i class="fas fa-question-circle text-info"></i> 分割払いは可能ですか？
              </button>
            </h6>
          </div>
          <div id="collapse11" class="collapse">
            <div class="card-body">
              クレジットカードでのお支払いの場合、カード会社によって分割払いやリボ払いが可能です。
              詳しくはご利用のカード会社にお問い合わせください。
            </div>
          </div>
        </div>
      </section>

      {{-- 返品・交換について --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-undo text-secondary"></i> 返品・交換について
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq12">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse12">
                <i class="fas fa-question-circle text-info"></i> 返品・交換は可能ですか？
              </button>
            </h6>
          </div>
          <div id="collapse12" class="collapse">
            <div class="card-body">
              商品に不良がある場合や、注文と異なる商品が届いた場合は、
              商品到着後7日以内にご連絡ください。返品・交換を承ります。
              お客様都合による返品・交換は、原則としてお受けできません。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq13">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse13">
                <i class="fas fa-question-circle text-info"></i> 返品時の送料は誰が負担しますか？
              </button>
            </h6>
          </div>
          <div id="collapse13" class="collapse">
            <div class="card-body">
              商品の不良や当社のミスによる返品の場合は、当社が送料を負担いたします。
              お客様都合による返品の場合は、お客様のご負担となります。
            </div>
          </div>
        </div>
      </section>

      {{-- その他 --}}
      <section class="mb-5">
        <h4 class="mb-4">
          <i class="fas fa-question text-info"></i> その他
        </h4>
        
        <div class="card mb-3">
          <div class="card-header" id="faq14">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse14">
                <i class="fas fa-question-circle text-info"></i> メールが届きません
              </button>
            </h6>
          </div>
          <div id="collapse14" class="collapse">
            <div class="card-body">
              迷惑メールフォルダに振り分けられている可能性があります。
              また、ドメイン指定受信を設定されている場合は、当サイトのドメインを許可してください。
              それでも届かない場合は、<a href="{{ route('contact') }}">お問い合わせ</a>ください。
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header" id="faq15">
            <h6 class="mb-0">
              <button class="btn btn-link text-left w-100 text-decoration-none collapsed" type="button" data-toggle="collapse" data-target="#collapse15">
                <i class="fas fa-question-circle text-info"></i> 個人情報の取り扱いについて
              </button>
            </h6>
          </div>
          <div id="collapse15" class="collapse">
            <div class="card-body">
              お客様の個人情報は、当社のプライバシーポリシーに基づき厳重に管理し、
              お客様の同意なく第三者に提供することはありません。
              詳しくはプライバシーポリシーをご覧ください。
            </div>
          </div>
        </div>
      </section>

      {{-- お問い合わせへの誘導 --}}
      <div class="card bg-light text-center mb-5">
        <div class="card-body">
          <h5 class="card-title">
            <i class="fas fa-envelope"></i> こちらで解決しない場合
          </h5>
          <p class="card-text">お気軽にお問い合わせください</p>
          <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">
            お問い合わせフォームへ
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
