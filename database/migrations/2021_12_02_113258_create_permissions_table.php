<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_approved')->default(0);
            $table->foreignId('permission_status_id')
                ->nullable()
                ->references('id')
                ->on('permission_statuses');
            $table->foreignId('permission_type_id')
                ->nullable()
                ->references('id')
                ->on('permission_types');
            $table->string('photo');
            $table->dateTime('start_date');
            $table->dateTime('due_date');
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
        Schema::dropIfExists('permissions');
    }
}
