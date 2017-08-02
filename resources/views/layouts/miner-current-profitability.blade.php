
<span>Based on payments</span>
<table class="table table-bordered">
<tbody>
	<tr><th scope="row">Last 24h</th> <td>{{ ucfirst($miner->coin->name) }} {{ round($amounts['last_day'], 2) }} (Estimation: {{ round($estimated_profitability['default']['coin_per_day'],2) }})</td></tr>
	<tr><th scope="row">Last week</th> <td>{{ ucfirst($miner->coin->name) }} {{ round($amounts['last_week'], 2) }} (Estimation: {{ round($estimated_profitability['default']['coin_per_week'],2) }})</td></tr>
	<tr><th scope="row">Last month</th> <td>{{ ucfirst($miner->coin->name) }} {{ round($amounts['last_month'], 2) }} (Estimation: {{ round($estimated_profitability['default']['coin_per_month'],2) }})</td></tr>
	<tr><th scope="row">Last 3 month</th> <td>{{ ucfirst($miner->coin->name) }} {{ round($amounts['last_three_months'], 2) }} (Estimation: {{ round(($estimated_profitability['default']['coin_per_month']*3),2) }})</td></tr>
</tbody>
</table>