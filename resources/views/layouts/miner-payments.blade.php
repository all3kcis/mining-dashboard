<table class="table table-bordered">
<tbody>
	<tr><th scope="row">Total last 24h</th> <td>{{ round($amounts['last_day'], 2) }}</td></tr>
	<tr><th scope="row">Total</th> <td>{{ round($amounts['all_time'], 2) }}</td></tr>
</tbody>
</table>



<table class="table table-striped" id="miner_last_txs">
<tbody>
@forelse ($transactions as $transaction)
	<tr><td scope="row" title="{{ $transaction->txid }}" style="font-size: 0.8em;">{{ $transaction->txid }}</td> <td>{{ round($transaction->value, 2) }}</td></tr>
@empty
	<tr><td scope="row" colspan="2" style="text-align:center;">No transactions at the moment.</td></tr>
@endforelse
</tbody>
</table>