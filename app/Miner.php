<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miner extends Model
{

	//protected $table = 'miners';

	protected $fillable = [
        'name', 'coin_id', 'speed', 'min_speed', 'moy_speed', 'max_speed', 'consumption_in_watt', 'consumption_cost_per_month', 'price', 'wallet_address', 'start_date', 'calcul_with_offpeak_hours'
    ];


    public function getLastTransactions($nb=5){
        return \App\Payment::where('wallet_address', $this->wallet_address)->limit($nb)->orderBy('time', 'DESC')->get();
    }

    public function setCalculWithOffpeakHoursAttribute($value)
    {
        $this->attributes['calcul_with_offpeak_hours'] = (strtolower($value) == 'on' ? 1 : 0);
    }

    public function coin(){
        return $this->belongsTo('App\Coin');
    }

    public function pool(){
        return $this->belongsTo('App\Pool');
    }
}
