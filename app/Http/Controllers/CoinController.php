<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CoinController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// Todo , valid coin exist
		$rules = array(
			'name'       => 'required',
			'short_name' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('/')
				->withErrors($validator);
		} else {

			$coin = new \App\Coin();
			$coin->fill($request->all());
			$coin->save();

			Session::flash('message', 'Coin successfully created!');
			return Redirect::route('home');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$coin = \App\Coin::findOrFail($id);
		$estimated_coin_per_day_per_mh = Controller::calculCoinPerDay(1, $coin->difficulty, $coin->block_reward);

		return view('coin', compact('coin', 'estimated_coin_per_day_per_mh'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$rules = array(
			'name'       => 'required',
			'short_name' => 'required',
		);

		$validator = Validator::make($request->all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('/')
				->withErrors($validator);
		} else {

			$coin = \App\Coin::findOrFail($id);
			$coin->fill($request->all());
			$coin->save();

			Session::flash('message', 'Coin successfully updated!');
			return Redirect::route('coin', $id);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}


	public function sync($id){
		$coin = \App\Coin::findOrFail($id);

		if($coin->rate_api != 'litebit'){
			Session::flash('message', 'Sorry, "'.$coin->rate_api.'"" is currently not supported.');
			return Redirect::route('home');
		}

		if($coin->informations_api != 'coinwarz'){
			Session::flash('message', 'Sorry, "'.$coin->informations_api.'"" is currently not supported.');
			return Redirect::route('home');
		}

		if (empty($coin->last_update) or time() - strtotime($coin->last_update) > 1800){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.litebit.eu/market/'.strtolower($coin->short_name));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200){
				curl_close($ch);
				Session::flash('message', 'Error while getting '.$coin->name.' infos.');
			}else{
				curl_close($ch);
				$json_result = json_decode($result);

				if($json_result->success === true){
					$coin->sell_price = floatval($json_result->result->sell);
					$coin->buy_price = floatval($json_result->result->buy);
					$coin->last_update = date('Y-m-d H:i:s');
					

					$rate_api_result = true;
				}else{
					$rate_api_result = false;
				}
			}

			// https://www.coinwarz.com/v1/api/documentation
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.coinwarz.com/v1/api/coininformation/?apikey='.env('API_KEY_COINWARZ').'&cointag='.strtoupper($coin->short_name));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($ch);
			if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200){
				curl_close($ch);
				Session::flash('message', 'Error while getting '.$coin->name.' infos.');
			}else{
				curl_close($ch);
				$json_result = json_decode($result);

				if($json_result->Success === true){
					$coin->algorithm = $json_result->Data->Algorithm;
					$coin->difficulty = $json_result->Data->Difficulty;
					$coin->block_reward = $json_result->Data->BlockReward;
					$coin->last_update = date('Y-m-d H:i:s');

					$informations_api_result = true;
				}else{
					$informations_api_result = false;
				}
			}

			if ($rate_api_result or $informations_api_result){
				$coin->save();
				if ($rate_api_result AND $informations_api_result){
					Session::flash('message', 'Successfully synchronization for '.$coin->name.' coin!');
				}else{
					Session::flash('message', 'Partial synchronization for '.$coin->name.' coin!');
				}
			}else{
				Session::flash('message', 'Error during synchronisation of '.$coin->name.' coin.');
			}
			

		}else{
			Session::flash('message', 'Nothing to sync.');
		}

		return Redirect::route('home');
	}
}
