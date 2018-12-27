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
            $table->unsignedInteger('status_id');
            $table->date('bid_date');
            $table->string('manufacturer')->nullable();
            $table->string('product');
            $table->unsignedInteger('product_sales_id');
            $table->unsignedInteger('inside_sales_id');
            $table->unsignedInteger('amount');
            $table->string('apc_opp_id')->nullable();
            $table->string('invoice_link')->nullable();
            $table->string('engineer')->nullable();
            $table->string('contractor')->nullable();
            $table->timestamps();


            $table->foreign('status_id')->references('id')->on('project_status');
            $table->foreign('product_sales_id')->references('id')->on('users');
            $table->foreign('inside_sales_id')->references('id')->on('users');
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
