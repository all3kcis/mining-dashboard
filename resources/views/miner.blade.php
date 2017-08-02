@extends('layouts.default')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1 class="page-header">{{ $miner->name }}</h1>

	<div class="col-md-4">

	<div class="panel panel-primary">
		<div class="panel-heading" style="font-weight: bold;font-size: 1.3em;">Miner informations</div>
		<div class="panel-body">
		
			<!-- if there are creation errors, they will show here -->
			@if (count( $errors ) > 0 )
				@foreach ($errors->all() as $error)
					<div class="alert alert-danger">{{ $error }}</div>
				@endforeach
			@endif

			<form action="{{ url('miner/'.$miner->id)}}" class="form-horizontal" method="POST">

				{{ csrf_field() }}
				<div class="form-group">
					<label for="name" class="col-sm-4 control-label">Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $miner->name }}">
					</div>
				</div>

				<div class="form-group">
					<label for="coin_id" class="col-sm-4 control-label">Coin</label>
					<div class="col-sm-8">

						<select class="form-control" id="coin_id" name="coin_id">
							@forelse (App\Coin::all() as $coin)
								<option value="{{ $coin->id }}" {{ ($coin->id == $miner->coin_id ?'selected':'') }}>{{ $coin->name }} ({{ strtoupper($coin->short_name) }})</option>
							@empty
								<option value="0">First, please add cryptocurrency.</option>
							@endforelse
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="coin_id" class="col-sm-4 control-label">Pool</label>
					<div class="col-sm-8">

						<select class="form-control" id="pool_id" name="pool_id">
							@forelse (App\Pool::all() as $pool)
								@if ($loop->first)
									<option value="0" >Choose pool</option>
								@endif
								<option value="{{ $pool->id }}" {{ ($pool->id == $miner->pool_id ?'selected':'') }}>{{ $pool->name }} ({{ $pool->type }})</option>
							@empty
								<option value="0">Oops, no pool at the moment.</option>
							@endforelse
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="speed" class="col-sm-4 control-label">Speed</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="speed" name="speed" placeholder="Speed in Mh/s" value="{{ $miner->speed }}">
							<span class="input-group-addon">Mh/s</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="min_speed" class="col-sm-4 control-label">Minimum speed</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="min_speed" name="min_speed" placeholder="Min speed in Mh/s" value="{{ $miner->min_speed }}">
							<span class="input-group-addon">Mh/s</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="moy_speed" class="col-sm-4 control-label">Average speed</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="moy_speed" name="moy_speed" placeholder="Average speed in Mh/s" value="{{ $miner->moy_speed }}">
							<span class="input-group-addon">Mh/s</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="max_speed" class="col-sm-4 control-label">Maximum speed</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="max_speed" name="max_speed" placeholder="Max speed in Mh/s" value="{{ $miner->max_speed }}">
							<span class="input-group-addon">Mh/s</span>
						</div>
					</div>
				</div>	
						

				<div class="form-group">
					<label for="consumption_in_watt" class="col-sm-4 control-label">Power consumption</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="consumption_in_watt" name="consumption_in_watt" placeholder="Power consumption" value="{{ $miner->consumption_in_watt }}">
							<span class="input-group-addon">Watts</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="consumption_cost_per_month" class="col-sm-4 control-label">Consumption cost<br />Calculate : 0</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="consumption_cost_per_month" name="consumption_cost_per_month" placeholder="Consumption cost" value="{{ $miner->consumption_cost_per_month }}">
							<span class="input-group-addon">€/month</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="price" class="col-sm-4 control-label">Price</label>
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" id="price" name="price" placeholder="Price" value="{{ $miner->price }}">
							<span class="input-group-addon">€</span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="wallet_address" class="col-sm-4 control-label">Wallet</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="wallet_address" name="wallet_address" placeholder="Wallet" value="{{ $miner->wallet_address }}">
					</div>
				</div>

				<div class="form-group">
					<label for="pool_api_key" class="col-sm-4 control-label">Pool API key</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="pool_api_key" name="pool_api_key" placeholder="Pool API key" value="{{ $miner->pool_api_key }}">
					</div>
				</div>

				<div class="form-group">
					<label for="start_date" class="col-sm-4 control-label">Starting date</label>
					<div class="col-sm-8">
						<input type="datetime" class="form-control" id="start_date" name="start_date" placeholder="Format : 2017-01-01" value="{{ $miner->start_date }}">
					</div>
				</div>

	
					<div class="checkbox" style="margin-bottom:15px;text-align: center;">
						<label>
							<input type="checkbox" name="calcul_with_offpeak_hours" {{ ($miner->calcul_with_offpeak_hours ? 'checked' : '') }}> Working only in offpeak hours. (not implemented)
						</label>
					</div>


				
				<button type="submit" class="btn btn-danger">Delete</button>
				<button type="submit" class="btn btn-success">Update</button>
			</form>
		</div>
	</div>

	</div>

	<div class="col-md-4">
		<div class="col-md-12">
			<h2 class="sub-header">Pool statistics</h2>
			{{ $miner->pool->name or 'Not available.' }}
		</div>

		<div class="col-md-12">
			<h2 class="sub-header">Estimated rentability</h2>
			@include('layouts.miner-estimated-rentability')
		</div>
	</div>


	<div class="col-md-4">

		<div class="col-md-12">
			<h2 class="sub-header">Payments<div style="float: right;font-size: 0.65em;"><a href="{{ route('miner_payments', $miner->id)  }}">Details</a> <a href="{{ route('miner_sync_payments', $miner->id) }}">Sync</a></div></h2>
			@include('layouts.miner-payments')
		</div>

		<div class="col-md-12">
			<h2 class="sub-header">Current profitability</h2>
			@include('layouts.miner-current-profitability')
		</div>

	</div>

</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
	<div class="col-md-4">

	</div>
</div>
@endsection