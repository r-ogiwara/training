<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFuriganaToCategorieMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_masters', function (Blueprint $table) {
            //
            $table->string('furigana')->nullable()->after('categorie_name'); //カラム追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorie_masters', function (Blueprint $table) {
            //
            $table->dropColumn('id');  //カラムの削除
        });
    }
}
