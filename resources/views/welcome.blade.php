@extends('layouts.default')

@section('content')
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1 class="page-header">Dashboard - Global Stats</h1>

	<div class="col-md-4">

		<!-- if there are creation errors, they will show here -->
		@if (count( $errors ) > 0 )
			@foreach ($errors->all() as $error)
				<div class="alert alert-danger">{{ $error }}</div>
			@endforeach
		@endif


		<h2 class="sub-header">Add a miner</h2>
		<form action="{{ url('miner')}}" class="form-horizontal" method="POST">

			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			</div>

			<div class="form-group">
				<label for="coin_id" class="col-sm-4 control-label">Cryptocurrency</label>
				<div class="col-sm-8">

					<select class="form-control" id="coin_id" name="coin_id">
						@forelse (App\Coin::all() as $coin)
							<option value="{{ $coin->id }}">{{ $coin->name }} ({{ strtoupper($coin->short_name) }})</option>
						@empty
							<option value="0">First, please add a cryptocurrency</option>
						@endforelse
					</select>
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-block">Create</button>
		</form>

	</div>

	<div class="col-md-4">
		<h2 class="sub-header">Add cryptocurrency</h2>
		<form action="{{ url('coin')}}" class="form-horizontal" method="POST">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			</div>

			<div class="form-group">
				<label for="short_name" class="col-sm-4 control-label">Short name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="short_name" name="short_name" placeholder="Short name">
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-block">Create</button>
		</form>

	</div>

	<div class="col-md-4">
		<h2 class="sub-header">Add pool</h2>
		TODO
		<form action="{{ url('coin')}}" class="form-horizontal" method="POST">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name" class="col-sm-4 control-label">Name</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-block">Create</button>
		</form>

	</div>

</div> 
@endsection