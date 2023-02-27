<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="name">Name</label>
        <input  name="name" id="name" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>
<div class="row justify-content-md-center">
    <div class="col-md-6">
        <div class="form-group">
            <label for="cost">Shipping Cost</label>
            <input  name="cost" id="cost" value="{{$data->cost}}" required="" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="duration">Shipping Duration</label>
            <input  name="duration" id="duration" value="{{$data->duration}}" required="" type="text" class="form-control">
        </div>
    </div>

    <div class="col-md-12">
    <div class="form-group">
        <span for="location_id">Shipping Location</span>
        <select name="location_id[]" id="showMenuSourch" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose">
            @php $shipping_location = ($data->location_id) ? json_decode($data->location_id) : []; @endphp
            <option  @if(in_array('all', $shipping_location)) selected @endif value="all">All Location</option>
            @foreach($locations as $location)
            <option  @if(in_array($location->id, $shipping_location)) selected @endif value="{{$location->id}}">{{$location->name}}</option>
            @endforeach
        </select>
       
    </div>
</div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="notes">Details</label>
        <input  name="notes" id="notes" value="{{$data->notes}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">logo</label>
        <input data-default-file="{{asset('upload/images/shipping/'.$data->logo)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="logo" id="input-file-events">
    </div>
    @if ($errors->has('logo'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('logo') }}
        </span>
    @endif
</div>



<div class="col-md-12 mb-12">

    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($data->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>

</div>

