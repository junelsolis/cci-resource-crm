<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('manufacturer');
            $table->string('product');
            $table->tinyInteger('status_id');
            $table->date('ship_date');
            $table->integer('amount');
            $table->integer('sales_user_id');
            $table->integer('apc_opp_id');
            $table->string('engineer');
            $table->string('contractor');
            $table->text('notes');
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
        Schema::dropIfExists('projects');
    }
}
