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
            $table->string('name');
            $table->tinyInteger('status_id');
            $table->date('bid_date');
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('product');
            $table->integer('service_sales_id');
            $table->integer('amount');
            $table->integer('apc_opp_id')->nullable();
            $table->string('invoice_link')->nullable();
            $table->string('engineer')->nullable();
            $table->string('contractor')->nullable();
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
