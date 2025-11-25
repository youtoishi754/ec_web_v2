<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Favorite;
use App\TGoods;

class FavoriteController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * お気に入りに追加
     */
    public function add(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'ログインが必要です。']);
        }

        $goodsId = $request->input('goods_id');
        $user = Auth::user();

        // 既にお気に入りに登録されているかチェック
        $exists = Favorite::where('user_id', $user->id)
            ->where('goods_id', $goodsId)
            ->exists();

        if ($exists) {
            // 既に登録済みの場合も成功として返す
            $count = Favorite::where('user_id', $user->id)->count();
            return response()->json([
                'success' => true, 
                'count' => $count
            ]);
        }

        // お気に入りに追加
        Favorite::create([
            'user_id' => $user->id,
            'goods_id' => $goodsId,
        ]);

        // 現在のお気に入り数を取得
        $count = Favorite::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true, 
            'count' => $count
        ]);
    }

    /**
     * お気に入りから削除
     */
    public function remove(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'ログインが必要です。']);
        }

        $goodsId = $request->input('goods_id');
        $user = Auth::user();

        // お気に入りから削除
        $deleted = Favorite::where('user_id', $user->id)
            ->where('goods_id', $goodsId)
            ->delete();

        // 現在のお気に入り数を取得
        $count = Favorite::where('user_id', $user->id)->count();

        return response()->json([
            'success' => true, 
            'message' => 'お気に入りから削除しました。',
            'count' => $count,
            'deleted' => $deleted
        ]);
    }

    /**
     * お気に入り一覧を表示
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['error' => 'ログインが必要です。']);
        }

        $user = Auth::user();
        $favorites = $user->favoriteGoods()
            ->where('t_goods.delete_flg', 0)
            ->where('t_goods.disp_flg', 1)
            ->get();

        return view('favorites.index', compact('favorites'));
    }
}
