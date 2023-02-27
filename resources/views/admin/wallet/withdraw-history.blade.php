<table class="table display table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Withdraw Date</th>
            <th>Amount</th>
            <th>Commission</th>
            <th>Payment Info</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>

    @if(count($withdraws)>0)
        @foreach($withdraws as $index => $withdraw)
        <tr>
        	<td>{{$index+1 }}</td>
           <td>{{\Carbon\Carbon::parse($withdraw->created_at)->format(Config::get('siteSetting.date_format'))}}
           ({{\Carbon\Carbon::parse($withdraw->created_at)->diffForHumans()}})
           </td>
            <td> <span class="label label-info">{{Config::get('siteSetting.currency_symble'). $withdraw->amount }}</span></td>
            <td>{{ Config::get('siteSetting.currency_symble'). $withdraw->commission }}</td>
            <td>{{ ($withdraw->paymentGateway) ? $withdraw->paymentGateway->method_name : $withdraw->payment_method }}<br/>
                                   
            @if($withdraw->transaction_details) Account no : {{$withdraw->transaction_details}} @endif
            </td>
            <td>@if($withdraw->status == 'paid') <span class="label label-success"> {{$withdraw->status}}</span> @elseif($withdraw->status == 'received') <span class="label label-primary"> {{$withdraw->status}} </span> @elseif($withdraw->status == 'cancel') <span class="label label-danger"> {{$withdraw->status}} </span> 
            @else <span class="label label-info"> {{$withdraw->status}} </span> @endif</td>
        </tr>
       @endforeach
    @else <tr><td colspan="8"> <h1>No Withdraw found.</h1></td></tr>@endif

    </tbody>
</table>