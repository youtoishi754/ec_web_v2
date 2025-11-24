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
    <div class="alert alert-success mt-3">
      {{ session('success') }}
    </div>
  @endif

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
    {{-- ユーザー情報カード --}}
    <div class="col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-user"></i> ユーザー情報</h5>
        </div>
        <div class="card-body">
          <table class="table table-borderless table-sm">
            <tr>
              <th style="width: 35%;">お名前</th>
              <td>
                @if(auth()->user()->last_name || auth()->user()->first_name)
                  {{ auth()->user()->last_name }} {{ auth()->user()->first_name }}
                @endif
              </td>
            </tr>
            <tr>
              <th>フリガナ</th>
              <td>
                @if(auth()->user()->last_name_kana || auth()->user()->first_name_kana)
                  {{ auth()->user()->last_name_kana }} {{ auth()->user()->first_name_kana }}
                @endif
              </td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td>{{ auth()->user()->email }}</td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>{{ auth()->user()->phone }}</td>
            </tr>
            <tr>
              <th>郵便番号</th>
              <td>{{ auth()->user()->postal_code }}</td>
            </tr>
            <tr>
              <th>ご住所</th>
              <td>
                @if(auth()->user()->prefecture || auth()->user()->city || auth()->user()->address)
                  {{ auth()->user()->prefecture }}{{ auth()->user()->city }}{{ auth()->user()->address }}
                  @if(auth()->user()->building)
                    <br>{{ auth()->user()->building }}
                  @endif
                @endif
              </td>
            </tr>
            <tr>
              <th>生年月日</th>
              <td>
                @if(auth()->user()->birthday)
                  {{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('Y年m月d日') }}
                @endif
              </td>
            </tr>
            <tr>
              <th>性別</th>
              <td>
                @if(auth()->user()->gender !== null)
                  @if(auth()->user()->gender == 1)
                    男性
                  @elseif(auth()->user()->gender == 2)
                    女性
                  @else
                    その他
                  @endif
                @endif
              </td>
            </tr>
            <tr>
              <th>会員登録日</th>
              <td>{{ auth()->user()->created_at->format('Y年m月d日') }}</td>
            </tr>
          </table>
          <div class="text-center mt-3">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#profileModal">
              <i class="fas fa-edit"></i> プロフィール編集
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- 注文履歴カード --}}
    <div class="col-md-6 mb-4">
      <div class="card h-100">
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
      <div class="card h-100">
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
      <div class="card h-100">
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

  {{-- アカウント設定セクション --}}
  <h4 class="mt-4 mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
    <i class="fas fa-cog"></i> アカウント設定
  </h4>

  <div class="row">
    {{-- パスワード変更カード --}}
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <i class="fas fa-key fa-3x mb-3 text-primary"></i>
          <h5 class="card-title">パスワード変更</h5>
          <p class="card-text">セキュリティのため、定期的にパスワードを変更することをお勧めします。</p>
          <button class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">変更する</button>
        </div>
      </div>
    </div>

    {{-- メールアドレス変更カード --}}
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <i class="fas fa-envelope fa-3x mb-3 text-info"></i>
          <h5 class="card-title">メールアドレス変更</h5>
          <p class="card-text">ログイン時に使用するメールアドレスを変更できます。</p>
          <button class="btn btn-info" data-toggle="modal" data-target="#emailModal">変更する</button>
        </div>
      </div>
    </div>

    {{-- 退会カード --}}
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body text-center">
          <i class="fas fa-user-times fa-3x mb-3 text-danger"></i>
          <h5 class="card-title">退会手続き</h5>
          <p class="card-text">アカウントを削除します。この操作は取り消せません。</p>
          <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">退会する</button>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4 text-center mb-5">
    <a href="{{ route('goods_list') }}" class="btn btn-primary btn-lg">
      <i class="fas fa-shopping-cart"></i> 商品一覧へ
    </a>
  </div>
</div>

{{-- プロフィール編集モーダル --}}
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="profileModalLabel"><i class="fas fa-edit"></i> プロフィール編集</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mypage_profile_update') }}" method="POST">
        @csrf
        <div class="modal-body">
          {{-- お名前 --}}
          <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-user"></i> お名前</h6>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="last_name">姓 <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                       id="last_name" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" required>
                @error('last_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name">名 <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                       id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" required>
                @error('first_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="last_name_kana">姓（カナ） <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('last_name_kana') is-invalid @enderror" 
                       id="last_name_kana" name="last_name_kana" value="{{ old('last_name_kana', auth()->user()->last_name_kana) }}" placeholder="ヤマダ" required>
                @error('last_name_kana')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="first_name_kana">名（カナ） <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name_kana') is-invalid @enderror" 
                       id="first_name_kana" name="first_name_kana" value="{{ old('first_name_kana', auth()->user()->first_name_kana) }}" placeholder="タロウ" required>
                @error('first_name_kana')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          {{-- ご住所 --}}
          <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-map-marker-alt"></i> ご住所</h6>
          <div class="form-group">
            <label for="postal_code">郵便番号 <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                   id="postal_code" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}" placeholder="123-4567" required>
            @error('postal_code')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="prefecture">都道府県 <span class="text-danger">*</span></label>
            <select name="prefecture" id="prefecture" class="form-control @error('prefecture') is-invalid @enderror" required>
              <option value="">選択してください</option>
              @php
                $prefectures = ['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'];
                $currentPrefecture = old('prefecture', auth()->user()->prefecture);
              @endphp
              @foreach($prefectures as $pref)
                <option value="{{ $pref }}" {{ $currentPrefecture == $pref ? 'selected' : '' }}>{{ $pref }}</option>
              @endforeach
            </select>
            @error('prefecture')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="city">市区町村 <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                   id="city" name="city" value="{{ old('city', auth()->user()->city) }}" placeholder="渋谷区" required>
            @error('city')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="address">番地 <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                   id="address" name="address" value="{{ old('address', auth()->user()->address) }}" placeholder="道玄坂1-2-3" required>
            @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="building">建物名・部屋番号</label>
            <input type="text" class="form-control @error('building') is-invalid @enderror" 
                   id="building" name="building" value="{{ old('building', auth()->user()->building) }}" placeholder="○○マンション101号">
            @error('building')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- 連絡先 --}}
          <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-phone"></i> 連絡先</h6>
          <div class="form-group">
            <label for="phone">電話番号 <span class="text-danger">*</span></label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="09012345678" required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- その他の情報 --}}
          <h6 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-info-circle"></i> その他の情報（任意）</h6>
          <div class="form-group">
            <label for="birthday">生年月日</label>
            <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                   id="birthday" name="birthday" value="{{ old('birthday', auth()->user()->birthday) }}">
            @error('birthday')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="gender">性別</label>
            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
              @php $currentGender = old('gender', auth()->user()->gender); @endphp
              <option value="">選択しない</option>
              <option value="1" {{ $currentGender == '1' ? 'selected' : '' }}>男性</option>
              <option value="2" {{ $currentGender == '2' ? 'selected' : '' }}>女性</option>
              <option value="0" {{ $currentGender == '0' ? 'selected' : '' }}>その他</option>
            </select>
            @error('gender')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> 更新する
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- パスワード変更モーダル --}}
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="passwordModalLabel"><i class="fas fa-key"></i> パスワード変更</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mypage_password_update') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="current_password">現在のパスワード <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                   id="current_password" name="current_password" required>
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_password">新しいパスワード <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                   id="new_password" name="new_password" required minlength="8">
            <small class="form-text text-muted">8文字以上で入力してください。</small>
            @error('new_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_password_confirmation">新しいパスワード（確認） <span class="text-danger">*</span></label>
            <input type="password" class="form-control" 
                   id="new_password_confirmation" name="new_password_confirmation" required minlength="8">
            <small class="form-text text-muted">確認のため、もう一度入力してください。</small>
          </div>

          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> パスワードは定期的に変更することをお勧めします。
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="submit" class="btn btn-primary">パスワードを変更する</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- メールアドレス変更モーダル --}}
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="emailModalLabel"><i class="fas fa-envelope"></i> メールアドレス変更</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mypage_email_update') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> 現在のメールアドレス: <strong>{{ Auth::user()->email }}</strong>
          </div>

          <div class="form-group">
            <label for="email">新しいメールアドレス <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="password_email">パスワード（確認用） <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password_email" name="password" required>
            <small class="form-text text-muted">セキュリティのため、現在のパスワードを入力してください。</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> メールアドレスを変更すると、次回ログイン時には新しいメールアドレスを使用します。
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="submit" class="btn btn-info">メールアドレスを変更する</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- 退会確認モーダル --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> 退会の確認</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mypage_delete') }}" method="POST" id="delete-form">
        @csrf
        <div class="modal-body">
          <div class="alert alert-danger">
            <h6><i class="fas fa-exclamation-circle"></i> 注意事項</h6>
            <ul class="mb-0">
              <li>退会すると、アカウント情報が完全に削除されます。</li>
              <li>削除されたアカウントは復元できません。</li>
              <li>同じメールアドレスで再登録することは可能です。</li>
              <li>購入履歴などの情報も削除されます。</li>
            </ul>
          </div>

          <p class="text-danger font-weight-bold">本当に退会してもよろしいですか？</p>

          <div class="form-group">
            <label for="password_delete">パスワード（確認用） <span class="text-danger">*</span></label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password_delete" name="password" required>
            <small class="form-text text-muted">セキュリティのため、現在のパスワードを入力してください。</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="confirm">確認入力 <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('confirm') is-invalid @enderror" 
                   id="confirm" name="confirm" placeholder="「退会する」と入力してください" required>
            <small class="form-text text-muted">本当に退会する場合は、「退会する」と入力してください。</small>
            @error('confirm')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
          <button type="submit" class="btn btn-danger" 
                  onclick="return confirm('本当に退会しますか？この操作は取り消せません。')">
            <i class="fas fa-user-times"></i> 退会する
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// エラーがある場合、該当するモーダルを自動的に開く
@if ($errors->has('last_name') || $errors->has('first_name') || $errors->has('postal_code') || $errors->has('phone'))
  $(document).ready(function() {
    $('#profileModal').modal('show');
  });
@elseif ($errors->has('current_password') || $errors->has('new_password'))
  $(document).ready(function() {
    $('#passwordModal').modal('show');
  });
@elseif ($errors->has('email') || ($errors->has('password') && old('email')))
  $(document).ready(function() {
    $('#emailModal').modal('show');
  });
@elseif ($errors->has('confirm') || ($errors->has('password') && old('confirm')))
  $(document).ready(function() {
    $('#deleteModal').modal('show');
  });
@endif
</script>
@endsection
