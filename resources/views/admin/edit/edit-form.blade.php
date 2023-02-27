<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="name">Name</label>
        <input  name="name" id="name" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="notes">Notes</label>
        <input  name="notes" id="notes" value="{{$data->notes}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">Feature Image</label>
        <input data-default-file="{{asset('upload/images/category/'.$data->image)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
    </div>
    @if ($errors->has('phato'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('phato') }}
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

