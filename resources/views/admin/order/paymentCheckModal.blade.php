<form id="withdrawMakePaymentForm" onsubmit="return confirm('Are you sure update this order payment info.?')" action="{{route('admin.changePaymentStatus')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
        	<input type="hidden" name="order_id" value="{{ $order->order_id }}">
            <table class="">
                <tr><td style="text-align: right;font-weight: bold;">Customer Name:</td><td> {{ $order->shipping_name }}</td></tr>
                <tr><td style="text-align: right;font-weight: bold;">Total Amount:</td><td>  {{$order->currency_sign . (($order->user_type==2?$order->customer_total_price:$order->total_price) + $order->shipping_cost - $order->coupon_discount)  }}</td>
                <tr><td style="text-align: right;font-weight: bold;">Payable Amount:</td><td>  {{$order->currency_sign . (($order->user_type==2?$order->customer_total_price:$order->total_price) + $order->shipping_cost - $order->coupon_discount - $order->orderPartialPayments->sum('amount'))  }}</td>
                </tr>
                <tr>
                <td style="text-align: right;font-weight: bold;">Customer Name:</td><td> {{ $order->shipping_name }}</td></tr>
            </table>
      
            <span style="font-weight: bold;">Payment Information:</span><br/>
            @if($order->tnx_id) Trnx Id: {{$order->tnx_id}} <br> @endif {{ $order->payment_info}}
            @foreach($order->orderPartialPayments as $index => $notify)
               <p style="font-size: 12px;padding: 0;margin: 0">By {{($notify->staff) ? $notify->staff->name : '' }} => {{$notify->payment_method .' '. $order->currency_sign.$notify->amount }} ({{\Carbon\Carbon::parse($notify->created_at)->format(Config::get('siteSetting.date_format'))}}) <br/> A/C: {{$notify->account_no}}, Tnx_id: {{ $notify->transaction_id}}, Tnx_details: {{ $notify->transaction_details}}</p>
            @endforeach
        </div>

        <div class="col-md-12">
            <label for="amount"><span style="font-weight: bold">Received Amount</span></label>
            <input type="text" required id="amount" name="amount" placeholder="Enter received amount" class="form-control">
       	</div> 

        <div class="col-md-6">
            <label for="account_no"><span style="font-weight: bold">Pay Account No</span></label>
            <input type="text" required="" id="account_no" name="account_no" placeholder="Enter Account No" class="form-control">
        </div>    

        <div class="col-md-6">
            <label for="transaction_id"><span style="font-weight: bold">Payment Transaction Id</span></label>
            <input type="text" name="transaction_id" onblur="checkField(this.value, 'transaction_id')" required onkeyup="checkField(this.value, 'transaction_id')" placeholder=" Transaction Id" class="form-control">
            <span id="transaction_id"></span>
        </div>

        <div class="col-md-12">
            <label for="notes"><span style="font-weight: bold">Payment Info</span></label>
            <textarea required style="width:100%;resize: vertical;" rows="2" name="transaction_details" id="transaction_details"  placeholder="Write payment Info" class="form-control"></textarea>
        </div>

        <div class="col-md-12">
            <label for="notes">Payment Status</label>
            <select name="payment_status" required="" class="form-control" id="status">
                <option value="">Select Status</option>
                <option @if($order->payment_status== 'pending') selected @endif value="pending">Pending</option>
                <option @if($order->payment_status== 'received') selected @endif value="received">Received</option>
                @if(Auth::guard('admin')->user()->role_id == 'admin')
                <option @if($order->payment_status== 'paid') selected @endif value="paid">Paid</option>
                @endif
            </select>
        </div>

        @if($order->order_status != 'cancel' && $order->order_status != 'delivered')
        <div class="col-md-12">
            <p style="background:#f7e2a6b3;font-size: 12px;padding:5px;"><span style="font-weight: bold">Notes:</span>Please make sure is the customer then update payment info.</p>
            <div class="modal-footer">
                <button type="submit" id="submitBtn" class="btn btn-success"> <i class="fa fa-save"></i> Update payment</button>
            </div>
        </div>
        @endif
    </div>
</form>