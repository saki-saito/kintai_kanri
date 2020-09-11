<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanniKinmuTorokuStartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanni_kinmu_toroku_starts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kinmu_toroku_id');
            $table->time('kanni_kinmu_start_time');
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
        Schema::dropIfExists('kanni_kinmu_toroku_starts');
    }
}
