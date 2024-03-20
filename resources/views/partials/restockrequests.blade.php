@foreach ($restock_reqs as $req)
<tr>
    <td >#{{$req->id}}</td>
    <td>{{\Carbon\Carbon::parse($req->created_at)->format('d/m/Y g:i A')}}</td>
    <td>By {{$req->user->name}}</td>
    <td>
        @if ($req->status == true)
        <i class="fa-solid fa-circle text-success"></i> Complete
        @else
        <i class="fa-solid fa-circle text-danger"></i> Pending
        @endif      
    </td>
</tr>
@endforeach