

@if (empty($miner->consumption_cost_per_month))
	<div class="alert alert-danger">Power consumption is not used.</div>
@endif
@if (empty($miner->coin->sell_price))
	<div class="alert alert-danger">Sell price is not defined.</div>
@endif

<table class="table table-bordered">
<tbody>
	<tr>
		<th scope="row">
			{{ ucfirst($miner->coin->name) }} /hour<br />
			<span class="estimated_profitability_default_value">{{ round($estimated_profitability['default']['coin_per_hour'], 4) }}</span>
		</th>
		<td>

			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['coin_per_hour'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['coin_per_hour'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['coin_per_hour'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
		<th scope="row">
			{{ ucfirst($miner->coin->name) }} /day<br />
			<span class="estimated_profitability_default_value">{{ round($estimated_profitability['default']['coin_per_day'], 4) }}</span>
		</th>
		<td>

			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['coin_per_day'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['coin_per_day'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['coin_per_day'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
		<th scope="row">
			{{ ucfirst($miner->coin->name) }} /week<br />
			<span class="estimated_profitability_default_value">{{ round($estimated_profitability['default']['coin_per_week'], 4) }}</span>
		</th>
		<td>

			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['coin_per_week'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['coin_per_week'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['coin_per_week'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
		<th scope="row">
			{{ ucfirst($miner->coin->name) }} /month<br />
			<span class="estimated_profitability_default_value">{{ round($estimated_profitability['default']['coin_per_month'], 4) }}</span>
		</th>
		<td>

			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['coin_per_month'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['coin_per_month'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['coin_per_month'], 4) }}<br />
				@endif
			</div>
		</td>
		</tr>

	<tr>
		<th scope="row">
			€/hour<br />
			<span class="estimated_profitability_default_value" title="{{ $estimated_profitability['default']['euro_per_hour_details'] }}">{{ round($estimated_profitability['default']['amount_euros']['per_hour'], 4) }}</span>
		</th>
		<td>
			
			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['amount_euros']['per_hour'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['amount_euros']['per_hour'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['amount_euros']['per_hour'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
		<th scope="row">
			€/day<br />
			<span class="estimated_profitability_default_value" title="{{ $estimated_profitability['default']['euro_per_day_details'] }}">{{ round($estimated_profitability['default']['amount_euros']['per_day'], 4) }}</span>
		</th>
		<td>

			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['amount_euros']['per_day'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Moy : {{ round($estimated_profitability['moy']['amount_euros']['per_day'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['amount_euros']['per_day'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
	<th scope="row">
		€/week<br />
		<span class="estimated_profitability_default_value" title="{{ $estimated_profitability['default']['euro_per_week_details'] }}">{{ round($estimated_profitability['default']['amount_euros']['per_week'], 4) }}</span>
	</th>
		<td>
			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ round($estimated_profitability['min']['amount_euros']['per_week'], 4) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Avg : {{ round($estimated_profitability['moy']['amount_euros']['per_week'], 4) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ round($estimated_profitability['max']['amount_euros']['per_week'], 4) }}<br />
				@endif
			</div>
		</td>
	</tr>

	<tr>
		<th scope="row">
			€/month<br />
			<span class="estimated_profitability_default_value" title="{{ $estimated_profitability['default']['euro_per_month_details'] }}">{{ round($estimated_profitability['default']['amount_euros']['per_month'], 4) }}</span>
		</th>
		<td>
			<div class="estimated_profitability_min_to_max">
				@if ($estimated_profitability['min'])
					Min : {{ ($estimated_profitability['min']['amount_euros']['per_month']) }}<br />
				@endif
				@if ($estimated_profitability['moy'])
					Avg : {{ ($estimated_profitability['moy']['amount_euros']['per_month']) }} <br />
				@endif
				@if ($estimated_profitability['max'])
					Max : {{ ($estimated_profitability['max']['amount_euros']['per_month']) }}<br />
				@endif
			</div>
		</td>
	</tr>

</tbody>
</table>

@if ($miner->price)

<table class="table table-bordered">
<tbody>
	<tr><th scope="row"  width="50%">Amortization<br />(current rate)</th> <td>
	{{  $amortization_month=((ceil($miner->price / $estimated_profitability['default']['amount_euros']['per_month']) > 0) ? ceil($miner->price / $estimated_profitability['default']['amount_euros']['per_month']): '&infin;')  }} month
	@if ($miner->start_date AND $amortization_month > 0)
		<br />{{  date('Y-m-d', strtotime('+'.$amortization_month.' months', strtotime($miner->start_date)))  }}
	@endif
	</td></tr>
	
</tbody>
</table>

@endif

<table class="table table-bordered">
<tbody>
	<tr><th scope="row"  width="50%">Unit price</th> <td>Profit / month (todo)</td></tr>
	<tr><th scope="row" width="50%"><div class="input-group"><input type="numeric" class="form-control" value="0.05" width="4"><span class="input-group-addon">€</span></div></th> <td>0<span>€</span></td></td></tr>
	<tr><th scope="row" width="50%"><div class="input-group"><input type="numeric" class="form-control" value="0.05" width="4"><span class="input-group-addon">€</span></div></th> <td>0<span>€</span></td></td></tr>
	<tr><th scope="row" width="50%"><div class="input-group"><input type="numeric" class="form-control" value="0.05" width="4"><span class="input-group-addon">€</span></div></th> <td>0<span>€</span></td></td></tr>
</tbody>
</table>
