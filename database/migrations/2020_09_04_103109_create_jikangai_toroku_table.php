<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJikangaiTorokuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jikangai_toroku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kinmu_toroku_id');
            $table->time('jikangai_start_time');
            $table->time('jikangai_end_time');
            $table->string('jikangai_riyu', 60);
            $table->time('jikangai_kyukei_start_time');
            $table->time('jikangai_kyukei_end_time');
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
        Schema::dropIfExists('jikangai_toroku');
    }
}
