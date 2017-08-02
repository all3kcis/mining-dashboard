<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('coin_id')->unsigned()->nullable();
            $table->integer('pool_id')->unsigned()->nullable();
            $table->float('speed')->nullable(); /* speed in Mh/S */
            $table->float('min_speed')->nullable(); /* speed in Mh/S */
            $table->float('moy_speed')->nullable(); /* speed in Mh/S */
            $table->float('max_speed')->nullable(); /* speed in Mh/S */
            $table->integer('consumption_in_watt')->nullable();
            $table->integer('consumption_cost_per_month')->nullable();
            $table->integer('price')->nullable();
            $table->string('wallet_address')->nullable();
            $table->string('pool_api_key')->nullable();
            $table->date('start_date')->nullable();
            $table->tinyInteger('calcul_with_offpeak_hours')->default(0);
            $table->timestamps();
            $table->softDeletes();


             $table->foreign('coin_id')->references('id')->on('coins');
             $table->foreign('pool_id')->references('id')->on('pools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miners');
    }
}
