<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="title">Coupon Cpde</label>
        <input required="" name="coupon_code" id="title" value="{{$data->coupon_code}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="type">Type</label>
        <select class="form-control" name="type" id="type" required>
        <option >Choose a type</option>
        <option @if($data->coupon_code = 0) selected @endif value="0">Percentage</option>
        <option @if($data->coupon_code = 1) selected @endif value="1">Fixed Amount</option>
      </select>
    </div>
</div>

<div class="col-md-12" id="amountField">
    <div class="form-group">
        <label for="amount" id="typeTitle">Amount</label>
        <input required=""  name="amount" id="amount" value="{{$data->amount}}"  type="number" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="amount">Quantity</label>
        <select class="form-control" id="time">
            <option @if($data->times == null) selected @endif value="0">Unlimited</option>
            <option @if($data->times != null) selected @endif value="1">Limited</option>
        </select>
    </div>
</div>
<div class="col-md-12" id="times">
    <div class="form-group">
        <label for="value">Number of time</label>
        <input class="form-control" name="times" id="value" placeholder="Enter times" type="text" value="{{$data->times}}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="required" for="value">Start date</label>
        <input required="" value="{{ $data->start_date }}" class="form-control" name="start_date" placeholder="Enter date" type="date">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label class="required" for="value">Expired date</label>
        <input required="" value="{{ $data->expired_date }}" class="form-control" name="expired_date" placeholder="Enter date" type="date">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label style="background: #fff;top:-10px;z-index: 1" for="notes">Notes</label>
        <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="1">{{ $data->notes }}</textarea>
    </div>
</div>
<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($data->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                <label class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>

