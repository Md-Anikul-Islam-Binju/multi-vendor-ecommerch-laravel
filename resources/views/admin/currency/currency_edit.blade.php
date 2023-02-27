
<input type="hidden" name="id" value="{{ $currency->id }}">

<div class="row form-group">
    <label class="col-md-2 control-label" for="name">Name</label>
    <div class="col-md-10">
        <input type="text" placeholder="Name" id="name" name="name" value="{{ $currency->name }}" class="form-control" required>
    </div>
</div>


<div class="row form-group">
    <label class="col-md-2 control-label" for="symbol">Symbol</label>
    <div class="col-md-10">
        <input type="text" placeholder="Symbol" id="symbol" name="symbol" value="{{ $currency->symbol }}" class="form-control" required>
    </div>
</div>
<div class="row form-group">
    <label class="col-md-2 control-label" for="code">Code</label>
    <div class="col-md-10">
        <input type="text" placeholder="Code" id="code" name="code" value="{{ $currency->code }}" class="form-control" required>
    </div>
</div>
<div class="row form-group">
    <label class="col-md-2 control-label" for="exchange_rate">Exchange Rate</label>
    <div class="col-md-10">
        <input type="number" step="0.01" min="0" placeholder="Exchange Rate" id="exchange_rate" name="exchange_rate" value="{{ $currency->exchange_rate }}" class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="switch-box">Status</label>
    <div  class="status-btn" >
        <div class="custom-control custom-switch">
            <input name="status" {{($currency->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
            <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
        </div>
    </div>
</div>


