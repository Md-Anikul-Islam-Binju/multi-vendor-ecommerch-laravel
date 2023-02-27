<form id="withdrawMakePaymentForm" onsubmit="return confirm('Are you sure update this withdraw.?')" action="{{route('admin.changeWithdrawStatus')}}" method="post">
    @csrf
<div class="row">
    <div class="col-md-12">
    	<input type="hidden" name="withdraw_id" value="{{ $user->id }}">
    	<p><span style="font-weight: bold;">Customer Name:</span>  {{ $user->customer->name }}</p>
    	
    	<p><span style="font-weight: bold;"> Withdraw Amount:</span> {{Config::get('siteSetting.currency_symble'). $user->amount }}</p>
        @if($user->notes)
    	<p><span style="font-weight: bold">Payment Method: </span>@if($user->paymentGateway){{$user->paymentGateway->method_name}} @else {{$user->payment_method}} @endif</p>
        <p><span style="font-weight: bold">Account No: </span>{{ $user->account_no . $user->transaction_details }}</p>
        <p><span style="font-weight: bold">Customer Notes: </span>{{ $user->notes }}</p>
        @endif
    </div>

    <div class="col-md-12">
       
        <label for="notes"><span style="font-weight: bold">Payment Details</span></label>
        <textarea required style="width:100%;resize: vertical;" rows="2" name="transaction_details" id="transaction_details"  placeholder="Write payment details" class="form-control">{{ $user->transaction_details }}</textarea>
   	</div>
    <div class="col-md-12">
        <label for="notes">Request Status</label>
        <select name="status" required="" class="form-control" id="status">
            <option value="">Select Status</option>
            <option @if($user->status== 'pending') selected @endif value="pending">Request Pending</option>
            <option @if($user->status== 'accepted') selected @endif value="accepted">Request Accepted</option>
            <option @if($user->status== 'paid') selected @endif value="paid">Request Paid</option>
            <option @if($user->status== 'cancel') selected @endif value="cancel">Request Cancel</option>
        </select>
    </div>
    @if($user->status != 'cancel' && $user->status != 'paid')
    <div class="col-md-12">
        <p style="background:#f7e2a6b3;font-size: 12px;padding:5px;"><span style="font-weight: bold">Notes:</span>Please make sure is the customer then add payment.</p>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Update payment</button>
        </div>
    </div>
    @endif
</div>
</form>