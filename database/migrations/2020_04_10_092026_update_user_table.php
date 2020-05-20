<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname'); //苗字カラムを追加
            $table->string('firstname'); //名前カラムを追加
            $table->string('postcode'); //郵便番号カラムを追加
            $table->string('address1'); //都道府県カラムを追加
            $table->string('address2'); //市区町村カラムを追加
            $table->string('address3'); //番地等カラムを追加
            $table->dropColumn('email'); //メールアドレスカラム削除
            $table->dropColumn('email_verified_at'); //メールアドレスカラム削除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
