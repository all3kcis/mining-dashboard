<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    public function showForMiner($id){
        $miner = \App\Miner::findOrFail($id);

        return view('miner-payments', compact('miner'));
    }

    public static function sync($coin_short_name, $wallet_address){
    	$last_sychronised_transaction = null;
    	$new_transactions = array();

    	$last_payment_collection = \App\Payment::where('wallet_address', $wallet_address)->limit(1)->orderBy('time', 'DESC')->get();
    	
    	if (count($last_payment_collection)){
    		$last_sychronised_transaction = $last_payment_collection->first()->txid;
    	}

    	$transactions_list = self::getTransactions($coin_short_name, $wallet_address);

    	if (is_array($transactions_list)){
    		foreach ($transactions_list as $transaction) {
    			if($transaction['txid'] == $last_sychronised_transaction){
    				break;
    			}
    			$tmp_transaction = array();
    			$tmp_transaction['txid']=$transaction['txid'];
    			$tmp_transaction['time']=$transaction['time'];
    			$tmp_transaction['coin_short_name']=$coin_short_name;
    			$tmp_transaction['wallet_address']=$wallet_address;

    			foreach ($transaction['vout'] as $vout) {
    				foreach ($vout['scriptPubKey']['addresses'] as $addresse){
    					if($addresse == $wallet_address){
    						$tmp_transaction['value']=$vout['value'];
    						break 2;
    					}
    				}
    			}
				$new_transactions[] = $tmp_transaction;
    		}

    		if(count($new_transactions) > 0){
    			$res = \App\Payment::insert($new_transactions);
    			return $res;
    		}
    		return true;
    	}else{
    		
    	}
    	return false;
    }

    protected static function getTransactions($coin_short_name, $wallet_address){

    	$api_url = self::getAPIUrl($coin_short_name, $wallet_address, 'transactions');

    	if($api_url === false){
    		Session::flash('message', 'Sorry, this cryptocurrency is not supported at the moment.');
    		return false;
    	}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec ($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200){
			curl_close($ch);
			return false;
		}else{
			curl_close($ch);
			$json_result = json_decode($result, true);
			if(!empty($json_result['txs'])){
				return $json_result['txs'];
			}else{
				return false;
			}
		}
    }

    protected static function getAPIUrl($coin_short_name, $wallet_address, $endpoint){
    	if($coin_short_name == 'nlg'){
    		$url = 'https://blockchain.gulden.com/api/';
    		if($endpoint == 'addr'){
    			return $url.'addr/'.$wallet_address;
    		}else if($endpoint == 'transactions'){
    			return $url.'txs/?address='.$wallet_address;
    		}else if($endpoint == 'getInfo'){
    			return $url.'status?q=getInfo';
    		}else if($endpoint == 'getDifficulty'){
    			return $url.'status?q=getDifficulty';
    		}
    	}
    	return false;
    }
}
