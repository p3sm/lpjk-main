<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id');
            $table->integer('car_id');
            $table->dateTime('task_date_start');
            $table->dateTime('task_date_end');
            $table->text('task_deskription');
            $table->string('pic_name',100);
            $table->string('pic_phone',100);
            $table->integer('is_canceled');
            $table->string('canceled_by',500);
            $table->string('canceled_reason',100);
            $table->integer('is_started');
            $table->integer('is_finished');
            $table->dateTime('finished_date');
            $table->integer('is_draft');
            $table->integer('created_by');
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
        Schema::dropIfExists('task');
    }
}
