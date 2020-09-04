<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanniKinmuTorokuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanni_kinmu_toroku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kinmu_toroku_id');
            $table->time('kanni_kinmu_start_time');
            $table->time('kanni_kinmu_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kanni_kinmu_toroku');
    }
}
