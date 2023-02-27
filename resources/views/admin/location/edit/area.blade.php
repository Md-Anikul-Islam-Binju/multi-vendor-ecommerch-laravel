
<input type="hidden" value="{{$data->id}}" name="id">


<div class="col-md-12">
    <div class="form-group">
        <label for="area">Area</label>
        <input  name="name" id="area" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">                           
    <div class="form-group">
        <label for="city">City name</label>
        <select required name="city_id" id="city" class="form-control custom-select">
            @foreach($cities as $city)
                <option value="{{$city->id}}" {{($city->id == $data->city_id) ?  'selected' : ''}}>{{$city->name}}</option>
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

