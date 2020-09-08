<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKinmuTorokusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinmu_torokus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kinmu_komoku_id');
            $table->date('ymd');
            $table->timestamps();
            
            // 外部キー制約
            // onDelete('cascade')：参照先のデータが削除されたとき、このテーブルの該当のデータも一緒に消す
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kinmu_komoku_id')->references('id')->on('kinmu_komokus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kinmu_torokus');
    }
}
