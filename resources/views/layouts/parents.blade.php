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
  padding-top: 120px;
  }
  .container
  {
    flex:1;
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
 <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container d-flex flex-column">
      <div class="d-flex align-items-center w-100">
        <a class="navbar-brand" href="{{route('index')}}">サンプルECサイト</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="ml-auto d-flex align-items-center">
          @if(auth()->check())
            {{-- ログイン中の場合 --}}
            <a href="{{ route('mypage') }}" class="btn btn-outline-light mr-2">マイページ</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-outline-light mr-2">ログアウト</button>
            </form>
          @else
            {{-- 未ログインの場合 --}}
            <a href="{{ route('pre_register') }}" class="btn btn-outline-light mr-2">新規登録</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light mr-2">ログイン</a>
          @endif
          <a href="{{ route('cart') }}" class="btn btn-outline-light">
            <i class="fas fa-shopping-cart"></i> カート
          </a>
        </div>
      </div>
      <div class="w-100 d-flex mt-2">
        <a href="{{route('index')}}" class="btn btn-outline-light flex-fill mx-1 d-flex align-items-center justify-content-center">トップ</a>
        <a href="{{route('goods_list')}}" class="btn btn-outline-light flex-fill mx-1 d-flex align-items-center justify-content-center">商品一覧</a>
        <a href="#" class="btn btn-outline-light flex-fill mx-1 d-flex align-items-center justify-content-center">お問い合わせ</a>
        <a href="#" class="btn btn-outline-light flex-fill mx-1 d-flex align-items-center justify-content-center">よくある質問</a>
      </div>
    </div>
  </nav>
  
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
  
  @yield('content')

  {{-- フッター --}}
  <footer class="py-3 bg-dark absolute-bottom">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 2025 Yuta All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
