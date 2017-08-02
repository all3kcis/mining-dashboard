<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wallet_address');
            $table->string('coin_short_name');
            $table->string('txid');
            $table->integer('time')->nullable();
            $table->double('value', 15, 9);

            $table->unique(['wallet_address', 'coin_short_name', 'txid'], 'addr_coin_tx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
