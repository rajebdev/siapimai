<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('attende_status_id')->references('id')->on('attende_statuses');
            $table->foreignId('attende_type_id')->references('id')->on('attende_types');
            $table->datetime('attend_time')->default(DB::raw('NOW()'));
            $table->float('latitude')->default(0);
            $table->float('longitude')->default(0);
            $table->string('photo');
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
        Schema::dropIfExists('attendes');
    }
}
