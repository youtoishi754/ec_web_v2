@extends('layouts.parents')

@section('title', '配送先管理')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header mt-4 mb-4">配送先管理</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- 配送先一覧 -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">登録済み配送先</h5>
                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addAddressModal">
                        <i class="fas fa-plus"></i> 新しい配送先を追加
                    </button>
                </div>
                <div class="card-body">
                    @if($addresses->isEmpty())
                        <div class="alert alert-info">
                            配送先が登録されていません。新しい配送先を追加してください。
                        </div>
                    @else
                        @foreach($addresses as $address)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>
                                            {{ $address->name }}
                                            @if($address->is_default)
                                                <span class="badge badge-primary">デフォルト</span>
                                            @endif
                                        </h5>
                                        <p class="mb-1">{{ $address->full_address }}</p>
                                        <p class="mb-0"><i class="fas fa-phone"></i> {{ $address->phone }}</p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        @if(!$address->is_default)
                                            <form action="{{ route('orders.addresses.default', $address->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="fas fa-star"></i> デフォルトに設定
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('orders.addresses.delete', $address->id) }}" method="POST" class="d-inline" 
                                            onsubmit="return confirm('この配送先を削除してもよろしいですか?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger mb-1">
                                                <i class="fas fa-trash"></i> 削除
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <a href="{{ route('mypage') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> マイページに戻る
            </a>
        </div>
    </div>
</div>

<!-- 配送先追加モーダル -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('orders.addresses.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">新しい配送先を追加</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">宛名 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="postal_code">郵便番号 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                placeholder="1234567" maxlength="8" required>
                            <small class="form-text text-muted">ハイフンなしで入力してください</small>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="phone">電話番号 <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                placeholder="09012345678" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="prefecture_id">都道府県 <span class="text-danger">*</span></label>
                        <select class="form-control ja-select2" id="prefecture_id" name="prefecture_id" required>
                            <option value="">選択してください</option>
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture->id }}">{{ $prefecture->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">市区町村 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" 
                            placeholder="例: 渋谷区渋谷" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address_line">番地・建物名 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address_line" name="address_line" 
                            placeholder="例: 1-2-3 ○○マンション101号室" required>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                        <label class="form-check-label" for="is_default">
                            この配送先をデフォルトに設定する
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">追加する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
