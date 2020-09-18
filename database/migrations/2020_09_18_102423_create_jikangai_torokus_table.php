<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJikangaiTorokusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jikangai_torokus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kinmu_toroku_id');
            $table->time('jikangai_start_time');
            $table->time('jikangai_end_time');
            $table->string('jikangai_riyu');
            $table->time('jikangai_kyukei_start_time');
            $table->time('jikangai_kyukei_end_time');
            $table->timestamps();
            
            // 外部キー制約
            // onDelete('cascade')：参照先のデータが削除されたとき、このテーブルの該当のデータも一緒に消す
            $table->foreign('kinmu_toroku_id')->references('id')->on('kinmu_torokus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jikangai_torokus');
    }
}
