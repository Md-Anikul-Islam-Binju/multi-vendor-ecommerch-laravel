@if($order)
   
    @if($orderCancel)
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="form-group">
                <fieldset>
                <legend style="margin-bottom: 0">Cancel Reason:</legend>
                {!!$orderCancel->reason !!} 
                </fieldset>
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <fieldset>
                <legend style="margin-bottom: 0">Cancel Details:</legend>
                {!!$orderCancel->reason_details !!}             
            </fieldset>
            </div>
        </div>
    </div>
    @else
        @if($order->order_status == 'pending' || $order->order_status != 'cancel')
         <span style="color: red">আপনার cancel কৃত পণ্যের মূল্য {{$_SERVER['SERVER_NAME']}} ওয়ালেট ব্যালেন্সে যোগ হবে । উক্ত ওয়ালেট ব্যালেন্স শুধুমাত্র {{$_SERVER['SERVER_NAME']}} থেকে পণ্য ক্রয়ের ক্ষেত্রে ব্যবহারযোগ্য ।</span>
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required" for="reason">Order Cancel Reason</label>
                    <select required name="cancel_reason" class="form-control">
                        <option value="">Select canel reason</option>
                    @foreach($cancelReasons as $reason)
                        <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="required" for="reason_details">Write Reason Details</label>
                    <textarea class="form-control" required minlength="6" rows="3" id="reason_details" placeholder="Write Order Reason Details" name="reason_details"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" style="background: red" name="order_id" value="{{$order->order_id}}" class="btn btn-danger"> <i class="fa fa-trash"></i> Cancel Order</button>
        </div>
        @else
        <h4 style="color: red">Your order cancellation failed, Because your order {{ str_replace( '-', ' ', $order->order_status) }}</h4>
        @endif
    @endif
   
@else
<h3 style="color: red">Sorry order not found.</h3>
@endif

