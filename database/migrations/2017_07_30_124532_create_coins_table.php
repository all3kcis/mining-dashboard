<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('short_name');
            $table->string('algorithm')->nullable();
            $table->double('buy_price', 15, 9)->default(0);
            $table->double('sell_price', 15, 9)->default(0);
            $table->string('difficulty')->default(0);
            $table->double('block_reward', 15, 9)->default(0);
            $table->double('coin_per_mh_per_day')->default(0);
            $table->datetime('last_update')->nullable();
            $table->string('rate_api')->default('litebit');
            $table->string('informations_api')->default('coinwarz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
