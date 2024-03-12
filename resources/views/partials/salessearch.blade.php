@if($transaction_search)

<tr>
    <td>#{{ $transaction_search->id }}</td>
    <td>{{ \Carbon\Carbon::parse($transaction_search->created_at)->format('d/m/Y g:i A') }}
    </td>
    <td>{{ number_format($transaction_search->grandtotal, 2) }}</td>
</tr>

@else
    <tr>
       <td colspan="3" class="text-center"> <h5 class="text-danger">No results found!</h5></td>
    </tr>
@endif
