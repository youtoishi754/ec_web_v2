<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>@yield('title')</title>

  {{-- BootstrapベースCSSファイル --}}
  <link href="{{asset('public/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  {{-- ページレイアウト関連テンプレートCSSファイル --}}
  <link href="{{asset('public/css/modern-business.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('public/css/common.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/goods/top.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/goods/list.css') }}">

  {{-- カレンダーのCSSファイル --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
  
  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
  {{-- 商品管理一覧 --}}
  <link href="{{asset('public/css/goods.css')}}" rel="stylesheet">

  {{-- jQueryベースライブラリ --}}
  <script src="{{asset('public/vendor/jquery/jquery.min.js')}}"></script>

  {{-- カレンダーライブラリ --}}
  <script src="{{asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

  <!-- Select2.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

  <!-- Select2本体 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

  <!-- Select2日本語化 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/ja.js"></script>

  <script>
  $(function()
  {
    $('.ja-select2').select2
    ({
      language: "ja" //日本語化
    });
    
    {{-- 日本語化 --}}
    $.datepicker.regional['ja'] = 
    {
      closeText: '閉じる',
      prevText: '<前',
      nextText: '次>',
      currentText: '今日',
      monthNames: ['1月','2月','3月','4月','5月','6月',
      '7月','8月','9月','10月','11月','12月'],
      monthNamesShort: ['1月','2月','3月','4月','5月','6月',
      '7月','8月','9月','10月','11月','12月'],
      dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
      dayNamesShort: ['日','月','火','水','木','金','土'],
      dayNamesMin: ['日','月','火','水','木','金','土'],
      weekHeader: '週',
      dateFormat: 'yy/mm/dd',
      firstDay: 0,
      changeYear: true,  // 年選択をプルダウン化
      changeMonth: true,  // 月選択をプルダウン化
      isRTL: false,
      showMonthAfterYear: true,
      yearSuffix: '年'
    };
    $.datepicker.setDefaults($.datepicker.regional['ja']);

    {{-- 指定したテキストボックスにカレンダー表示 --}}
    $("#s_up_date").datepicker
    ({
      buttonImage: "{{asset('public/css/icon_calendar.png')}}",
      buttonText: "カレンダーから選択",
      buttonImageOnly: true,
      showOn: "both",
      beforeShow : function(input,inst)
      {
        //開く前に日付を上書き
        var year = $(this).parent().find("#s_up_year").val();
        var month = $(this).parent().find("#s_up_month").val();
        var date = $(this).parent().find("#s_up_day").val();
        $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
      },
      onSelect: function(dateText, inst)
      {
        //カレンダー確定時にフォームに反映
        var dates = dateText.split('/');
        $(this).parent().find("#s_up_year").val(dates[0]);
        $(this).parent().find("#s_up_month").val(dates[1]);
        $(this).parent().find("#s_up_day").val(dates[2]);
      }
    });

    $("#e_up_date").datepicker
    ({
      buttonImage: "{{asset('public/css/icon_calendar.png')}}",        
      buttonText: "カレンダーから選択", 
      buttonImageOnly: true,           
      showOn: "both",
      beforeShow : function(input,inst)
      {
      //開く前に日付を上書き
      var year = $(this).parent().find("#e_up_year").val();
      var month = $(this).parent().find("#e_up_month").val();
      var date = $(this).parent().find("#e_up_day").val();
      $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
      },
      onSelect: function(dateText, inst)
      {
        //カレンダー確定時にフォームに反映
        var dates = dateText.split('/');
        $(this).parent().find("#e_up_year").val(dates[0]);
        $(this).parent().find("#e_up_month").val(dates[1]);
        $(this).parent().find("#e_up_day").val(dates[2]);
      }                   
    });

    $("#s_ins_date").datepicker
    ({
      buttonImage: "{{asset('public/css/icon_calendar.png')}}",        
      buttonText: "カレンダーから選択", 
      buttonImageOnly: true,           
      showOn: "both",
      beforeShow : function(input,inst)
      {
        //開く前に日付を上書き
        var year = $(this).parent().find("#s_ins_year").val();
        var month = $(this).parent().find("#s_ins_month").val();
        var date = $(this).parent().find("#s_ins_day").val();
        $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
      },
      onSelect: function(dateText, inst)
      {
        //カレンダー確定時にフォームに反映
        var dates = dateText.split('/');
        $(this).parent().find("#s_ins_year").val(dates[0]);
        $(this).parent().find("#s_ins_month").val(dates[1]);
        $(this).parent().find("#s_ins_day").val(dates[2]);
      }                   
    });

    $("#e_ins_date").datepicker
    ({
      buttonImage: "{{asset('public/css/icon_calendar.png')}}",       
      buttonText: "カレンダーから選択", 
      buttonImageOnly: true,           
      showOn: "both",
      beforeShow : function(input,inst)
      {
        //開く前に日付を上書き
        var year = $(this).parent().find("#e_ins_year").val();
        var month = $(this).parent().find("#e_ins_month").val();
        var date = $(this).parent().find("#e_ins_day").val();
        $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
      },
      onSelect: function(dateText, inst)
      {
        //カレンダー確定時にフォームに反映
        var dates = dateText.split('/');
        $(this).parent().find("#e_ins_year").val(dates[0]);
        $(this).parent().find("#e_ins_month").val(dates[1]);
        $(this).parent().find("#e_ins_day").val(dates[2]);
      }                   
    });
  });

  {{-- フォームのアクションを動的変更する --}}
  function submitAction(value,method) 
  {
    $('form').attr('action', value);

    if(method == 'get')
    { 
      $('form').attr("method","GET");
    }
    else if(method == 'post')
    {
      $('form').attr("method","POST");
    }

    $('form').submit();
  }

  $(function()
  {
    $('#ClearButton').click(function()
    {
      $('#SearchForm input, #SearchForm select').each(function()
      {
        //checkboxまたはradioボタンの時
        if(this.type == 'checkbox' || this.type == 'radio')
        {
          //一律でチェックを外す
          this.checked = false;
        }
        else
        {
          //checkboxまたはradioボタンまたはselect以外の時
          // val値を空にする
          $(this).val('');
          $("select option:selected").select2({width: "100%"});
        }
      });  
    });
  });
  </script>
  <style>
  {{-- コンテナのスタイル --}}
  html
  {
    height: 100%;
  }
  body
  {
  min-height: 100%;
  display: flex;
  flex-direction: column;
  /* fixed-top のナビバー分の余白を確保（ナビの高さに合わせて調整） */
  padding-top: 80px;
  }
  .container
  {
    flex:1;
  }
  
  {{-- ヘッダーのスタイル --}}
  .site-header {
    background: linear-gradient(135deg, #c94341 0%, #d85f5d 100%);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }
  
  .site-header .navbar-brand {
    font-size: 2rem;
    font-weight: bold;
    color: white !important;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .site-header .navbar-brand i {
    font-size: 2.5rem;
  }
  
  .site-header .nav-link {
    color: white !important;
    font-weight: 500;
    font-size: 1.1rem;
    padding: 0.5rem 1.5rem !important;
    transition: all 0.3s ease;
  }
  
  .site-header .nav-link:hover {
    background-color: rgba(255,255,255,0.2);
    border-radius: 5px;
  }
  
  {{-- フッターのスタイル --}}
  .site-footer {
    background: linear-gradient(135deg, #c94341 0%, #d85f5d 100%);
    box-shadow: 0 -4px 6px rgba(0,0,0,0.1);
    padding: 2rem 0;
  }
  
  .site-footer a {
    color: white !important;
    text-decoration: none;
    font-weight: 500;
    transition: opacity 0.3s ease;
  }
  
  .site-footer a:hover {
    opacity: 0.8;
    text-decoration: underline;
  }
  
  .site-footer .copyright {
    color: white;
    font-size: 0.9rem;
  }
  
  {{-- カートバッジのスタイル --}}
  .cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: white;
    color: #c94341;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  }
  
  .cart-link {
    position: relative;
  }
  
  {{-- ハンバーガーメニューアイコンのスタイル --}}
  .navbar-toggler {
    border-color: rgba(255,255,255,0.5);
    background-color: rgba(255,255,255,0.1);
  }
  
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }
  
  .navbar-toggler:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
  }
  
  {{-- スマホ対応のレスポンシブスタイル --}}
  @media (max-width: 768px) {
    body {
      padding-top: 60px;
    }
    
    .site-header .navbar-brand {
      font-size: 1.2rem;
    }
    
    .site-header .navbar-brand i {
      font-size: 1.5rem;
    }
    
    .site-header .nav-link {
      font-size: 1rem;
      padding: 0.5rem 1rem !important;
    }
    
    .container {
      padding-left: 10px;
      padding-right: 10px;
    }
    
    h2 {
      font-size: 1.5rem;
    }
    
    h3 {
      font-size: 1.3rem;
    }
    
    .card-title {
      font-size: 1rem;
    }
    
    .btn {
      font-size: 0.9rem;
      padding: 0.4rem 0.8rem;
    }
    
    .breadcrumb {
      font-size: 0.85rem;
      padding: 0.5rem 0.75rem;
    }
    
    {{-- 商品一覧のカード --}}
    .col-md-3 {
      margin-bottom: 1rem;
    }
    
    {{-- マイページのカード --}}
    .col-md-6 {
      margin-bottom: 1rem;
    }
    
    {{-- テーブルをスクロール可能に --}}
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    
    table {
      font-size: 0.85rem;
    }
    
    {{-- フッター --}}
    .site-footer {
      font-size: 0.85rem;
      padding: 1rem 0;
    }
    
    .site-footer a {
      display: block;
      margin: 0.3rem 0;
    }
  }
  
  @media (max-width: 576px) {
    .site-header .navbar-brand {
      font-size: 1rem;
    }
    
    h2 {
      font-size: 1.3rem;
    }
    
    h3 {
      font-size: 1.1rem;
    }
    
    .btn {
      font-size: 0.85rem;
      padding: 0.35rem 0.7rem;
    }
    
    {{-- カート内の商品情報 --}}
    .cart-item-img {
      max-width: 80px;
    }
    
    /* Product list grid adjustments */
    .list .col-md-3 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    /* Sort form on mobile */
    .form-inline {
      display: block !important;
    }
    .form-inline label,
    .form-inline select,
    .form-inline input,
    .form-inline button {
      display: block;
      width: 100%;
      margin: 5px 0 !important;
    }
    
    /* Product detail adjustments */
    .col-md-6 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    /* Cart table mobile optimization */
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table th,
    .table td {
      white-space: nowrap;
    }
    
    /* Product detail table - allow text wrapping on mobile */
    .card-body .table-responsive .table th,
    .card-body .table-responsive .table td {
      white-space: normal;
      word-wrap: break-word;
      word-break: break-word;
    }
    .card-body .table-responsive .table th {
      min-width: 80px;
    }
    
    /* Mypage cards */
    .col-md-6.mb-4 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    /* Modal adjustments */
    .modal-dialog {
      margin: 0.5rem;
    }
    .modal-body {
      padding: 1rem;
    }
    
    /* Favorite star button size */
    .favorite-btn {
      font-size: 1.2rem !important;
      padding: 4px 8px !important;
    }
    
    /* Cart mobile card styles */
    .cart-item-card {
      border: 1px solid #dee2e6;
    }
    .cart-item-card .card-body {
      padding: 0.75rem;
    }
    .cart-item-card .card-title {
      font-size: 0.95rem;
      line-height: 1.3;
    }
    .cart-mobile-img {
      min-height: 120px;
      max-height: 180px;
    }
  }
  
  /* Extra small devices (phones in portrait, less than 576px) */
  @media (max-width: 576px) {
    /* Make cart buttons smaller */
    .btn-sm {
      padding: 0.2rem 0.4rem;
      font-size: 0.75rem;
    }
    
    /* Cart mobile image smaller on tiny screens */
    .cart-mobile-img {
      height: 100px !important;
      min-height: 100px;
      max-height: 100px;
    }
    
    /* Product card image adjustments */
    .card-img-top {
      max-height: 250px;
      object-fit: cover;
    }
    
    /* Pager summary text size */
    .text-muted {
      font-size: 0.8rem;
    }
    
    /* Ensure favorite list items stack properly */
    .favorite-item .col-md-3,
    .favorite-item .col-md-9 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    
    /* Form inputs on mobile */
    .form-control {
      font-size: 16px; /* Prevents zoom on iOS */
    }
    
    /* Image adjustments */
    .img-fluid {
      width: 100%;
      height: auto;
    }
    
    /* Pagination on mobile */
    .pagination {
      font-size: 0.85rem;
    }
    .page-link {
      padding: 0.4rem 0.6rem;
    }
  }
  </style>
  <script>
  // ensure body has top padding equal to fixed navbar height to avoid overlap
  function adjustBodyPaddingForNavbar(){
    var $nav = $('.navbar.fixed-top');
    if($nav.length){
      var h = $nav.outerHeight();
      $('body').css('padding-top', h + 'px');
    }
  }
  $(window).on('load resize', adjustBodyPaddingForNavbar);
  </script>
  <style>
  {{-- カレンダーアイコンのスタイル --}}
  img.ui-datepicker-trigger
  {
    cursor: pointer;
    margin-left: 5px!important;
    margin-right: 5px!important;
    vertical-align: middle;
  }
  </style>
</head>
<body>
 {{-- ナビゲーション --}}
 <nav class="navbar fixed-top navbar-expand-lg site-header">
    <div class="container">
      <a class="navbar-brand" href="{{route('index')}}">
        <i class="fas fa-shopping-cart"></i>
        SHOPPING SITE
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{route('index')}}">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('goods_list')}}">SHOP</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('about') }}">ABOUT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}">CONTACT</a>
          </li>
          @if(auth()->check())
            <li class="nav-item">
              <a class="nav-link" href="{{ route('mypage') }}">
                <i class="fas fa-user"></i> MYPAGE
              </a>
            </li>
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link btn btn-link" style="color: white !important;">LOGOUT</button>
              </form>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">LOGIN</a>
            </li>
          @endif
          <li class="nav-item">
            <a class="nav-link cart-link" href="{{ route('cart') }}">
              <i class="fas fa-shopping-cart"></i> CART
              @php
                $cart = session()->get('cart', []);
                $totalItems = 0;
                foreach($cart as $goodsId => $quantity) {
                  $totalItems += $quantity;
                }
              @endphp
              @if($totalItems > 0)
                <span class="cart-badge">{{ $totalItems }}</span>
              @endif
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  @if(isSessionDebugEnabled())
  {{-- セッションデバッグ情報 --}}
  <div class="container mt-3">
    <div class="card bg-light">
      <div class="card-header">
        <strong>🔍 セッションデバッグ情報</strong>
      </div>
      <div class="card-body">
        <h6>認証状態:</h6>
        <pre class="bg-white p-2 border">{{ auth()->check() ? 'ログイン中' : '未ログイン' }}</pre>
        
        @if(auth()->check())
        <h6>ログインユーザー:</h6>
        <pre class="bg-white p-2 border">{{ print_r(auth()->user()->toArray(), true) }}</pre>
        @endif
        
        <h6>セッション全体:</h6>
        <pre class="bg-white p-2 border" style="max-height: 400px; overflow-y: auto;">{{ print_r(session()->all(), true) }}</pre>
        
        <h6>セッションID:</h6>
        <pre class="bg-white p-2 border">{{ session()->getId() }}</pre>
      </div>
    </div>
  </div>
  @endif
  
  @yield('content')

  {{-- フッター --}}
  <footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6 text-center text-md-left mb-3 mb-md-0">
          <p class="copyright mb-0">© 2024 SHOPPING SITE</p>
        </div>
        <div class="col-md-6 text-center text-md-right">
          <a href="{{ route('about') }}" class="mx-2">ABOUT</a>
          <a href="{{ route('contact') }}" class="mx-2">CONTACT</a>
          <a href="#" class="mx-2">PRIVACY POLICY</a>
          <a href="{{ route('terms') }}" class="mx-2">TERMS OF SERVICE</a>
          <a href="{{ route('faq') }}" class="mx-2">FAQ</a>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
