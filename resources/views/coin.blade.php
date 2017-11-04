@extends('layouts.default')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1 class="page-header">{{ $coin->name }} ({{ strtoupper($coin->short_name) }})</h1>

	<div class="col-md-8">

		<!-- if there are creation errors, they will show here -->
		@if (count( $errors ) > 0 )
			@foreach ($errors->all() as $error)
				<div class="alert alert-danger">{{ $error }}</div>
			@endforeach
		@endif


		<h2 class="sub-header">Informations</h2>
		<form action="{{ url('coin/'.$coin->id)}}" class="form-horizontal" method="POST">

			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $coin->name }}">
				</div>
			</div>

			<div class="form-group">
				<label for="short_name" class="col-sm-4 control-label">Short name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Short name" value="{{ $coin->short_name }}">
				</div>
			</div>

			<div class="form-group">
				<label for="algorithm" class="col-sm-4 control-label">Algorithm</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="algorithm" name="algorithm" placeholder="Algorithm" value="{{ $coin->algorithm }}">
				</div>
			</div>

			<div class="form-group">
				<label for="coin_per_mh_per_day" class="col-sm-4 control-label">
				Coin per Mh/day
				@if ($estimated_coin_per_day_per_mh > 0)
				(Estimation : <span title="{{ round($estimated_coin_per_day_per_mh, 8) }}">{{ round($estimated_coin_per_day_per_mh, 6) }}</span>)
				@endif
				</label>
				<div class="col-sm-8">
					<div class="input-group">
						<input type="text" class="form-control" id="coin_per_mh_per_day" name="coin_per_mh_per_day" placeholder="Piece par Mh/jour" value="{{ $coin->coin_per_mh_per_day }}">
						<span class="input-group-addon">coin/Mh/day</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="buy_price" class="col-sm-4 control-label">Buy price<span class="star_field">*</span></label>
				<div class="col-sm-8">
					<div class="input-group">
						<input type="text" class="form-control" id="buy_price" name="buy_price" placeholder="Buy price" value="{{ $coin->buy_price }}">
						<span class="input-group-addon">€</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="sell_price" class="col-sm-4 control-label">Sell price<span class="star_field">*</span></label>
				<div class="col-sm-8">
					<div class="input-group">
						<input type="text" class="form-control" id="sell_price" name="sell_price" placeholder="Sell price" value="{{ $coin->sell_price }}">
						<span class="input-group-addon">€</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="difficulty" class="col-sm-4 control-label">Difficulty<span class="star_field">*</span></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="difficulty" name="difficulty" placeholder="Difficulty" value="{{ $coin->difficulty }}">
				</div>
			</div>

			<div class="form-group">
				<label for="block_reward" class="col-sm-4 control-label">Coin per block<span class="star_field">*</span></label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="block_reward" name="block_reward" placeholder="Coin per block" value="{{ $coin->block_reward }}">
				</div>
			</div>

			<div class="form-group">
				<label for="rate_api" class="col-sm-4 control-label">API (rate)</label>
				<div class="col-sm-8">
					<select class="form-control" id="rate_api" name="rate_api">
						<option value="litebit" {{ ($coin->rate_api != 'litebit' ?: 'selected' ) }}>Litebit</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="informations_api" class="col-sm-4 control-label">API (informations)</label>
				<div class="col-sm-8">
					<select class="form-control" id="informations_api" name="informations_api">
						<option value="coinwarz" {{ ($coin->informations_api != 'coinwarz' ?: 'selected' ) }}>Coinwarz</option>
					</select>
				</div>
			</div>

			<div class="alert alert-info">
				<span class="star_field">*</span> Fields automatically updated during synchronisation. 
			</div>			
			
			<button type="submit" class="btn btn-danger">Delete</button>
			<button type="submit" class="btn btn-success">Update</button>
		</form>


	</div>


</div> 
@endsection