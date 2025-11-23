<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTables extends Migration
{
    public function up()
    {
        // usersテーブル (ユーザー情報)
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // password_resetsテーブル (パスワードリセット用)
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // failed_jobsテーブル (ジョブ失敗ログ)
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // pre_registrationsテーブル (仮登録情報)
        Schema::create('pre_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('token');
            $table->timestamps();
        });

        // t_goodsテーブル (商品情報)
        Schema::create('t_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('un_id')->nullable();
            $table->string('goods_number')->nullable();
            $table->string('goods_name')->nullable();
            $table->integer('goods_price')->nullable();
            $table->integer('goods_stock')->nullable();
            $table->text('goods_detail')->nullable();
            $table->text('intro_txt')->nullable();
            $table->tinyInteger('disp_flg')->default(1);
            $table->tinyInteger('delete_flg')->default(0);
            $table->timestamp('ins_date')->useCurrent();
            $table->timestamp('up_date')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_goods');
        Schema::dropIfExists('pre_registrations');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('users');
    }
}