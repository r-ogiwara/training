<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdToArtCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('art_categories', function (Blueprint $table) {
            //
            $table->bigIncrements('id')->first(); //カラム追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('art_categories', function (Blueprint $table) {
            //
            $table->dropColumn('id');  //カラムの削除
        });
    }
}
