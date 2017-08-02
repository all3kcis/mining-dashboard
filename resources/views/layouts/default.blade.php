<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="{{ url('/') }}">

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="{{ asset('img/favicon.ico') }}">

		<title>{{ config('app.name', 'Mining Dashboard | By All3kcis') }}</title>

		<!-- Bootstrap core CSS -->
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="{{ asset('js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
		<script src="{{ asset('js/ie-emulation-modes-warning.js') }}"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Scripts -->
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>

	</head>
	<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Mining Dashboard | By All3kcis') }}</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ url('/') }}">Dashboard</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">

					<form class="form-horizontal" id="miner_select">
						<div class="input-group">
							<select name="miner" id="miner_id" class="form-control">
								@forelse (\App\Miner::all() as $miner)
									@if ($loop->first)
										<option value="0" >Choose miner</option>
									@endif
									<option value="{{ $miner->id }}">{{ $miner->name }} ({{ $miner->speed | 0 }}Mh/s)</option>
								@empty
									<option value="">Oops, no miner at the moment.</option>
								@endforelse
							</select>
							<span class="input-group-btn"><button type="submit" class="btn btn-default">Go !</button></span>
						</div>
						
					</form>

<br>

					@forelse (\App\Coin::all() as $coin)
						<div>
							<table class="table table-bordered">
							<tbody>
							<tr><th scope="row" colspan="2" style="text-align:center;"><a href="{{ route('coin', $coin->id) }}">{{ $coin->name }} ({{ strtoupper($coin->short_name) }})</a> <div style="float: right;"><a href="{{ url('coin_sync', $coin->id) }}">Sync</a></div></th></tr>
							<tr><th scope="row">Buy price</th> <td>{{ $coin->buy_price or 0 }}€</td></tr>
							<tr><th scope="row">Sell price</th> <td>{{ $coin->sell_price or 0 }}€</td></tr>
							<tr><td scope="row" colspan="2" title="Last update">{{ $coin->last_update or 'never' }}</td></tr>
							</tbody>
							</table>
						</div>
					@empty
					@endforelse

				</div>
				
				
					@yield('content')
				
			</div>
		</div>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
	<script src="{{ asset('js/holder.min.js') }}"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>

	</body>
</html>
