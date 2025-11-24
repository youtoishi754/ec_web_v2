@extends('layouts.parents')
@section('title', '本登録')
@section('content')
<div class="container">
  <h3 class="my-4">本登録</h3>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('pre_register_complete') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- メールアドレス -->
    <div class="card mb-3">
      <div class="card-header"><strong>メールアドレス</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="email">メールアドレス</label>
          <input type="email" id="email" class="form-control" value="{{ $email }}" readonly>
        </div>
      </div>
    </div>

    <!-- お名前 -->
    <div class="card mb-3">
      <div class="card-header"><strong>お名前</strong></div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="last_name">姓 <span class="text-danger">*</span></label>
              <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name">名 <span class="text-danger">*</span></label>
              <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="last_name_kana">姓（カナ） <span class="text-danger">*</span></label>
              <input type="text" name="last_name_kana" id="last_name_kana" class="form-control" value="{{ old('last_name_kana') }}" placeholder="ヤマダ" required>
              <small class="form-text text-muted">全角カタカナで入力してください</small>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="first_name_kana">名（カナ） <span class="text-danger">*</span></label>
              <input type="text" name="first_name_kana" id="first_name_kana" class="form-control" value="{{ old('first_name_kana') }}" placeholder="タロウ" required>
              <small class="form-text text-muted">全角カタカナで入力してください</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ご住所 -->
    <div class="card mb-3">
      <div class="card-header"><strong>ご住所</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="postal_code">郵便番号 <span class="text-danger">*</span></label>
          <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}" placeholder="123-4567" required>
          <small class="form-text text-muted">ハイフンありまたはなしで入力してください</small>
        </div>
        <div class="form-group">
          <label for="prefecture">都道府県 <span class="text-danger">*</span></label>
          <select name="prefecture" id="prefecture" class="form-control" required>
            <option value="">選択してください</option>
            <option value="北海道" {{ old('prefecture') == '北海道' ? 'selected' : '' }}>北海道</option>
            <option value="青森県" {{ old('prefecture') == '青森県' ? 'selected' : '' }}>青森県</option>
            <option value="岩手県" {{ old('prefecture') == '岩手県' ? 'selected' : '' }}>岩手県</option>
            <option value="宮城県" {{ old('prefecture') == '宮城県' ? 'selected' : '' }}>宮城県</option>
            <option value="秋田県" {{ old('prefecture') == '秋田県' ? 'selected' : '' }}>秋田県</option>
            <option value="山形県" {{ old('prefecture') == '山形県' ? 'selected' : '' }}>山形県</option>
            <option value="福島県" {{ old('prefecture') == '福島県' ? 'selected' : '' }}>福島県</option>
            <option value="茨城県" {{ old('prefecture') == '茨城県' ? 'selected' : '' }}>茨城県</option>
            <option value="栃木県" {{ old('prefecture') == '栃木県' ? 'selected' : '' }}>栃木県</option>
            <option value="群馬県" {{ old('prefecture') == '群馬県' ? 'selected' : '' }}>群馬県</option>
            <option value="埼玉県" {{ old('prefecture') == '埼玉県' ? 'selected' : '' }}>埼玉県</option>
            <option value="千葉県" {{ old('prefecture') == '千葉県' ? 'selected' : '' }}>千葉県</option>
            <option value="東京都" {{ old('prefecture') == '東京都' ? 'selected' : '' }}>東京都</option>
            <option value="神奈川県" {{ old('prefecture') == '神奈川県' ? 'selected' : '' }}>神奈川県</option>
            <option value="新潟県" {{ old('prefecture') == '新潟県' ? 'selected' : '' }}>新潟県</option>
            <option value="富山県" {{ old('prefecture') == '富山県' ? 'selected' : '' }}>富山県</option>
            <option value="石川県" {{ old('prefecture') == '石川県' ? 'selected' : '' }}>石川県</option>
            <option value="福井県" {{ old('prefecture') == '福井県' ? 'selected' : '' }}>福井県</option>
            <option value="山梨県" {{ old('prefecture') == '山梨県' ? 'selected' : '' }}>山梨県</option>
            <option value="長野県" {{ old('prefecture') == '長野県' ? 'selected' : '' }}>長野県</option>
            <option value="岐阜県" {{ old('prefecture') == '岐阜県' ? 'selected' : '' }}>岐阜県</option>
            <option value="静岡県" {{ old('prefecture') == '静岡県' ? 'selected' : '' }}>静岡県</option>
            <option value="愛知県" {{ old('prefecture') == '愛知県' ? 'selected' : '' }}>愛知県</option>
            <option value="三重県" {{ old('prefecture') == '三重県' ? 'selected' : '' }}>三重県</option>
            <option value="滋賀県" {{ old('prefecture') == '滋賀県' ? 'selected' : '' }}>滋賀県</option>
            <option value="京都府" {{ old('prefecture') == '京都府' ? 'selected' : '' }}>京都府</option>
            <option value="大阪府" {{ old('prefecture') == '大阪府' ? 'selected' : '' }}>大阪府</option>
            <option value="兵庫県" {{ old('prefecture') == '兵庫県' ? 'selected' : '' }}>兵庫県</option>
            <option value="奈良県" {{ old('prefecture') == '奈良県' ? 'selected' : '' }}>奈良県</option>
            <option value="和歌山県" {{ old('prefecture') == '和歌山県' ? 'selected' : '' }}>和歌山県</option>
            <option value="鳥取県" {{ old('prefecture') == '鳥取県' ? 'selected' : '' }}>鳥取県</option>
            <option value="島根県" {{ old('prefecture') == '島根県' ? 'selected' : '' }}>島根県</option>
            <option value="岡山県" {{ old('prefecture') == '岡山県' ? 'selected' : '' }}>岡山県</option>
            <option value="広島県" {{ old('prefecture') == '広島県' ? 'selected' : '' }}>広島県</option>
            <option value="山口県" {{ old('prefecture') == '山口県' ? 'selected' : '' }}>山口県</option>
            <option value="徳島県" {{ old('prefecture') == '徳島県' ? 'selected' : '' }}>徳島県</option>
            <option value="香川県" {{ old('prefecture') == '香川県' ? 'selected' : '' }}>香川県</option>
            <option value="愛媛県" {{ old('prefecture') == '愛媛県' ? 'selected' : '' }}>愛媛県</option>
            <option value="高知県" {{ old('prefecture') == '高知県' ? 'selected' : '' }}>高知県</option>
            <option value="福岡県" {{ old('prefecture') == '福岡県' ? 'selected' : '' }}>福岡県</option>
            <option value="佐賀県" {{ old('prefecture') == '佐賀県' ? 'selected' : '' }}>佐賀県</option>
            <option value="長崎県" {{ old('prefecture') == '長崎県' ? 'selected' : '' }}>長崎県</option>
            <option value="熊本県" {{ old('prefecture') == '熊本県' ? 'selected' : '' }}>熊本県</option>
            <option value="大分県" {{ old('prefecture') == '大分県' ? 'selected' : '' }}>大分県</option>
            <option value="宮崎県" {{ old('prefecture') == '宮崎県' ? 'selected' : '' }}>宮崎県</option>
            <option value="鹿児島県" {{ old('prefecture') == '鹿児島県' ? 'selected' : '' }}>鹿児島県</option>
            <option value="沖縄県" {{ old('prefecture') == '沖縄県' ? 'selected' : '' }}>沖縄県</option>
          </select>
        </div>
        <div class="form-group">
          <label for="city">市区町村 <span class="text-danger">*</span></label>
          <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" placeholder="渋谷区" required>
        </div>
        <div class="form-group">
          <label for="address">番地 <span class="text-danger">*</span></label>
          <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="道玄坂1-2-3" required>
        </div>
        <div class="form-group">
          <label for="building">建物名・部屋番号</label>
          <input type="text" name="building" id="building" class="form-control" value="{{ old('building') }}" placeholder="○○マンション101号">
        </div>
      </div>
    </div>

    <!-- 連絡先 -->
    <div class="card mb-3">
      <div class="card-header"><strong>連絡先</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="phone">電話番号 <span class="text-danger">*</span></label>
          <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="09012345678" required>
          <small class="form-text text-muted">ハイフンなしで入力してください</small>
        </div>
      </div>
    </div>

    <!-- その他の情報 -->
    <div class="card mb-3">
      <div class="card-header"><strong>その他の情報（任意）</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="birthday">生年月日</label>
          <input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday') }}">
        </div>
        <div class="form-group">
          <label for="gender">性別</label>
          <select name="gender" id="gender" class="form-control">
            <option value="">選択しない</option>
            <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>男性</option>
            <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>女性</option>
            <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>その他</option>
          </select>
        </div>
      </div>
    </div>

    <!-- パスワード -->
    <div class="card mb-3">
      <div class="card-header"><strong>パスワード</strong></div>
      <div class="card-body">
        <div class="form-group">
          <label for="password">パスワード <span class="text-danger">*</span></label>
          <input type="password" name="password" id="password" class="form-control" required>
          <small class="form-text text-muted">8文字以上で入力してください</small>
        </div>
        <div class="form-group">
          <label for="password_confirmation">パスワード（確認） <span class="text-danger">*</span></label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block mb-4">本登録する</button>
  </form>
</div>
@endsection
