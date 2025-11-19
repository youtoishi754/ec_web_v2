@extends('layouts.parents')
@section('title', 'ログイン')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <h3 class="mt-4 mb-4">ログイン</h3>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login_do') }}">
        @csrf

        <div class="form-group">
          <label for="email">メールアドレス</label>
          <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
          <label for="password">パスワード</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group form-check">
          <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
          <label class="form-check-label" for="remember">
            ログイン状態を保持する
          </label>
        </div>

        <button type="submit" class="btn btn-primary btn-block">ログイン</button>
      </form>

      <div class="text-center mt-3">
        <p>アカウントをお持ちでない方は<a href="{{ route('pre_register') }}">こちら</a>から新規登録</p>
      </div>
    </div>
  </div>
</div>
@endsection
