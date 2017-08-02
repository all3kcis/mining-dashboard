<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MinerController extends Controller
{

    protected static $transactions = [];

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
        );

        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator);
        } else {

            $miner = new \App\Miner();
            $miner->fill($request->all());
            $miner->save();

            Session::flash('message', 'Miner successfully created!');
            return Redirect::route('miner', $miner->id);
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
        $miner = \App\Miner::findOrFail($id);
        $transactions = $miner->getLastTransactions();

        $amounts = $this->calculRealAmount($miner);

        $coinsperday = $this->getCoinsPerDay($miner);

        $speed = $miner->speed ?: ( $miner->moy_speed ?: 0);
        $estimated_profitability['default'] = $this->getProfitability($miner, $speed);
        if($miner->min_speed)
            $estimated_profitability['min'] = $this->getProfitability($miner, $miner->min_speed);
        else
            $estimated_profitability['min'] = [];
        if($miner->moy_speed)
            $estimated_profitability['moy'] = $this->getProfitability($miner, $miner->moy_speed);
        else
            $estimated_profitability['moy'] = [];
        if($miner->max_speed)
            $estimated_profitability['max'] = $this->getProfitability($miner, $miner->max_speed);
        else
            $estimated_profitability['max'] = [];

        return view('miner', compact('miner', 'transactions', 'amounts', 'estimated_profitability'));
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
        // Todo , valid coin exist
        $rules = array(
            'name'       => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator);
        } else {

            $miner = \App\Miner::findOrFail($id);
            $miner->fill($request->all());
            if($request->input('calcul_with_offpeak_hours') === null){
                $miner->calcul_with_offpeak_hours = 0;
            }
            $miner->save();

            Session::flash('message', 'Miner successfully updated!');
            return Redirect::route('miner', $id);
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

    public function sync_payments($id){
        $miner = \App\Miner::findOrFail($id);
        
        if($miner->coin AND !empty($miner->wallet_address)){
            if(PaymentController::sync($miner->coin->short_name, $miner->wallet_address)){
                Session::flash('message', 'Successful transactions synchronization.');
            }
        }else{
            Session::flash('message', 'Please define coin and your wallet address.');
        }
        return Redirect::route('miner', $id);
    }


    protected function getProfitability(\App\Miner $miner, $speed){

        return $this->calculProfitability($miner, $speed);

    }

    protected function calculProfitability(\App\Miner $miner, $speed){

        $estimated_profitability=array(
            'coin_per_hour'=>0,
            'coin_per_day'=>0,
            'coin_per_week'=>0,
            'coin_per_month'=>0,
            'euro_per_hour'=>0,
            'euro_per_day'=>0,
            'euro_per_week'=>0,
            'euro_per_month'=>0,
            'euro_per_hour_details'=>0,
            'euro_per_day_details'=>0,
            'euro_per_week_details'=>0,
            'euro_per_month_details'=>0,

            'cost_estimated' => array(
                'per_hour'=>0,
                'per_day'=>0,
                'per_week'=>0,
                'per_month'=>0,
            ),
            'amount_euros' => array(
                'per_hour'=>0,
                'per_day'=>0,
                'per_week'=>0,
                'per_month'=>0,
            )
        );
        

        if($speed){

            // Todo consumption_in_watt
            // Todo calcul_with_offpeak_hours

            if($miner->consumption_cost_per_month){
                $cost_estimated['per_hour'] = ($miner->consumption_cost_per_month / 29) / 24;
            }else{
                $cost_estimated['per_hour'] = 0;
            }

            $coin_per_mhs_per_hour = $miner->coin->coin_per_mh_per_day / 24;
            $estimated_profitability['coin_per_hour'] = $coin_per_mhs_per_hour * $speed;
            $estimated_profitability['coin_per_day'] = ($miner->coin->coin_per_mh_per_day * $speed);
            $estimated_profitability['coin_per_week'] = $estimated_profitability['coin_per_day'] * 7;
            $estimated_profitability['coin_per_month'] = $estimated_profitability['coin_per_day'] * 29;

            $estimated_profitability['euro_per_hour'] = ($estimated_profitability['coin_per_hour'] * $miner->coin->sell_price);
            $estimated_profitability['euro_per_day'] = ($estimated_profitability['coin_per_day'] * $miner->coin->sell_price);
            $estimated_profitability['euro_per_week'] = ($estimated_profitability['coin_per_week'] * $miner->coin->sell_price);
            $estimated_profitability['euro_per_month'] = ($estimated_profitability['coin_per_month'] * $miner->coin->sell_price);

            $cost_estimated['per_day'] = ($cost_estimated['per_hour'] * 24);
            $cost_estimated['per_week'] = ($cost_estimated['per_day'] * 7);
            $cost_estimated['per_month'] = ($cost_estimated['per_hour'] * 24 * 29);

            $amount_euros['per_hour'] = $estimated_profitability['euro_per_hour'] - $cost_estimated['per_hour'];
            $amount_euros['per_day'] = $estimated_profitability['euro_per_day'] - $cost_estimated['per_day'];
            $amount_euros['per_week'] = $estimated_profitability['euro_per_week'] - $cost_estimated['per_week'];
            $amount_euros['per_month'] = $estimated_profitability['euro_per_month'] - $cost_estimated['per_month'];


            $estimated_profitability['euro_per_hour_details'] = $estimated_profitability['euro_per_hour'].'€/h - '.$cost_estimated['per_hour'].'€ éléctricité';
            $estimated_profitability['euro_per_day_details'] = $estimated_profitability['euro_per_day'].'€/j - '.$cost_estimated['per_day'].'€ éléctricité';
            $estimated_profitability['euro_per_week_details'] = $estimated_profitability['euro_per_week'].'€/j - '.$cost_estimated['per_week'].'€ éléctricité';
            $estimated_profitability['euro_per_month_details'] = $estimated_profitability['euro_per_month'].'€/m - '.$cost_estimated['per_month'].'€ éléctricité';

            $estimated_profitability['cost_estimated'] = $cost_estimated;
            $estimated_profitability['amount_euros'] = $amount_euros;
        }

        return $estimated_profitability;
    }

    protected function calculRealAmount(\App\Miner $miner){
        $amounts = [
            'last_day'=>0,
            'last_week'=>0,
            'last_month'=>0,
            'last_three_months'=>0,
            'all_time'=>0,
        ];

        if($miner->wallet_address){
            $day_limit = (24*60*60);
            $weekk_limit = $day_limit * 7;
            $month_limit = $day_limit * 29;
            $three_months_limit = $month_limit * 3;

            // real
            $amounts['last_day'] = \App\Payment::where([['wallet_address', '=',  $miner->wallet_address], ['time', '>=', time() - $day_limit]])->sum('value');
            $amounts['last_week'] = \App\Payment::where([['wallet_address', '=',  $miner->wallet_address], ['time', '>=', time() - $weekk_limit]])->sum('value');
            $amounts['last_month'] = \App\Payment::where([['wallet_address', '=',  $miner->wallet_address], ['time', '>=', time() - $month_limit]])->sum('value');
            $amounts['last_three_months'] = \App\Payment::where([['wallet_address', '=',  $miner->wallet_address], ['time', '>=', time() - $three_months_limit]])->sum('value');

            $amounts['all_time'] = \App\Payment::where('wallet_address',  $miner->wallet_address)->sum('value');

        }

        return $amounts;
    }


    public function getCoinsPerDay(\App\Miner $miner){
        // http://www.holynerdvana.com/2014/02/how-to-calculate-coins-per-day-for-any.html

        $difficulty = $miner->coin->difficulty;
        $reward = $miner->coin->block_reward;
        $hashrate = $miner->speed ?: ( $miner->moy_speed ?: 0);

        return Controller::calculCoinPerDay($hashrate, $difficulty, $reward);
    }
}
