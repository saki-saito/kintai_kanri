<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKinmuKomokusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kinmu_komokus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kinmu_name');
            $table->time('syotei_start_time');
            $table->time('syotei_end_time');
            $table->time('syotei_kyukei_start_time');
            $table->time('syotei_kyukei_end_time');
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
        Schema::dropIfExists('kinmu_komokus');
    }
}
