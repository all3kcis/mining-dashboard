<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    /*
    https://aikapool.com/xvg/index.php?page=api&action=getuserbalance&api_key=e91c708bbd09ee77b936869bb45be3ff1c338d12ead35005b944946bf784fee0
	https://github.com/MPOS/php-mpos/wiki/API-Reference

	{"getuserbalance":{"version":"1.0.0","runtime":182.34610557556,"data":{"coin_address":1,"paid":"0.000000000000000000000000000000","coinname":"Verge","currency":"XVG","exchange_url":"https:\/\/bittrex.com\/Market\/Index?MarketName=BTC-XVG","cron_payouts":1,"price":"0.00000106","price_currency":"BTC","ap_threshold":1500,"confirmed":"60.105423000000000000000000000000","unconfirmed":"0.000000000000000000000000000000","orphaned":"0.000000000000000000000000000000"}}} 

    */

    public function home(){

    	return view('welcome');
    }

    public static function calculCoinPerDay($hashrate, $difficulty, $reward){
    	$coinsperday=0;
    	
    	if ($difficulty > 0 AND $reward > 0 ){
            $seconds = 86400;
            $coinsperday = ($seconds * $reward * $hashrate / ($difficulty * (pow(2, 48) / 0x00000000ffff) ) * 1000000);
        }
        return $coinsperday;
    }
    
}
