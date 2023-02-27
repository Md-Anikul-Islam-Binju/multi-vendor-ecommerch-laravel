
<input type="hidden" value="{{$data->id}}" name="id">


<div class="col-md-12">
    <div class="form-group">
        <label for="city">City</label>
        <input  name="name" id="city" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">                           
    <div class="form-group">
        <label for="state">State name</label>
        <select required name="state_id" id="state" class="form-control custom-select">
            @foreach($states as $state)
                <option value="{{$state->id}}" {{($state->id == $data->state_id) ?  'selected' : ''}}>{{$state->name}}</option>
            @endforeach
        </select>
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

