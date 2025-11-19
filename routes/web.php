<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/********** 
 * 商品管理
 **********/
Route::get('/', 'GoodsController')->name('index');                         //トップ
// Route::get('/goods/add', 'Goods\GoodsAddController')->name('goods_add');              //新規登録
// Route::post('/goods/add/view', 'Goods\Add\GoodsAddViewController')->name('goods_add_view');     //登録確認
// Route::post('/goods/add/do', 'Goods\Add\GoodsAddDoController')->name('goods_add_do');         //登録完了
// Route::get('/goods/edit', 'Goods\GoodsEditController')->name('goods_edit');            //編集登録
// Route::post('/goods/edit/view', 'Goods\Edit\GoodsEditViewController')->name('goods_edit_view');   //編集確認
// Route::post('/goods/edit/do', 'Goods\Edit\GoodsEditDoController')->name('goods_edit_do');       //編集完了
// Route::get('/goods/detail', 'Goods\GoodsDetailController')->name('goods_detail');        //詳細
// Route::get('/goods/delete', 'Goods\GoodsDeleteController')->name('goods_delete');        //削除確認
// Route::post('/goods/delete/do', 'Goods\Delete\GoodsDeleteDoController')->name('goods_delete_do');   //削除
// Route::get('/', 'ContactController')->name('contact');                         //問い合わせ
// Route::post('/contact', 'ContactSubmitController')->name('contact_submit'); //問い合わせ送信
// Route::get('/contact/thanks', 'ContactThanksController')->name('contact_thanks'); //問い合わせ完了
 Route::get('/goods/list', 'Goods\GoodsListController')->name('goods_list'); //商品一覧
Route::get('/goods/detail', 'Goods\GoodsDetailController')->name('goods_detail'); //商品詳細
// Route::get('/goodslist/{id}', 'GoodslistShowController')->name('goodslist_show'); //商品詳細
// メール仮登録（最初にメールアドレスだけ登録する）
Route::get('/pre-register', 'Auth\PreRegistrationController@showForm')->name('pre_register');
Route::post('/pre-register', 'Auth\PreRegistrationController@store')->name('pre_register_do');
// 仮登録の確認リンク／本登録
Route::get('/pre-register/confirm/{token}', 'Auth\\PreRegistrationController@confirm')->name('pre_register_confirm');
Route::post('/pre-register/complete', 'Auth\\PreRegistrationController@complete')->name('pre_register_complete');

// ログイン・ログアウト
Route::get('/login', 'Auth\\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\\LoginController@login')->name('login_do');
Route::post('/logout', 'Auth\\LoginController@logout')->name('logout');

// カート機能
Route::post('/cart/add', 'Cart\\CartController@add')->name('cart_add');
Route::get('/cart', 'Cart\\CartController@index')->name('cart');
Route::post('/cart/remove', 'Cart\\CartController@remove')->name('cart_remove');
Route::post('/cart/clear', 'Cart\\CartController@clear')->name('cart_clear');
