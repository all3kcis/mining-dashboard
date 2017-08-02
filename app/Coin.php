<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{

	public $timestamps = false;
	protected $fillable = [
        'name', 'short_name', 'algorithm', 'coin_per_mh_per_day', 'buy_price', 'sell_price', 'difficulty', 'block_reward', 'rate_api', 'informations_api'
    ];


    public function miners(){
        return $this->hasMany('App\Miner');
    }
}
