<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="title">Title</label>
        <input name="title" id="title" value="{{$data->title}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="sub_title">Sub Title</label>
        <input name="sub_title" id="sub_title" value="{{$data->sub_title}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="name">Bacground Color</label>
        <input name="background_color" value="{{$data->background_color}}" class="form-control gradient-colorpicker"  type="text">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="name">Text Color</label>
        <input name="text_color" value="{{$data->text_color}}" class="form-control gradient-colorpicker" type="text">
    </div>
</div>
<div class="col-md-4 col-6">
    <div class="form-group"> 
        <label class="dropify_image">Image</label>
        <input data-default-file="{{asset('upload/images/offer/'.$data->image)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="5M"  name="image" id="input-file-events">
        <i class="image_size">Image Size:400px * 250px </i>
    </div>
    @if ($errors->has('image'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('image') }}
        </span>
    @endif
</div>
    <div class="col-md-8 col-6">
        <div class="form-group"> 
            <label class="dropify_image">Banner Image</label>
            <input  type="file" data-default-file="{{asset('upload/images/offer/banner/'.$data->banner)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="banner" id="input-file-events">
            <i class="image_size">Image Size:1200px * 300px </i>
        </div>
        @if ($errors->has('banner'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('banner') }}
            </span>
        @endif
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

