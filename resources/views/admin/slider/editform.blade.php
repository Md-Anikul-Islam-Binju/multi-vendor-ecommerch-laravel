<input type="hidden" value="{{$data->id}}" name="id">
<input type="hidden" name="type" value="{{$data->type}}">

<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">Feature Image</label>
        <input data-default-file="{{asset('upload/images/slider/'.$data->phato)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
        <p style="color:red">homepage Image Size: 715px * 445px</p>
    </div>
    @if ($errors->has('phato'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('phato') }}
        </span>
    @endif
</div>
<div class="col-md-4">
    <div class="form-group">
        <label  for="btn_text">Button Name</label>
        <input type="text" value="{{$data->btn_text}}" placeholder="Exm: Shop Now" id="btn_text" name="btn_text" class="form-control">
           
    </div>
</div>
<div class="col-md-8">
    <div class="form-group">
        <label  for="btn_link">Button Link</label>
        <input type="text" id="btn_link" value="{{$data->btn_link}}" name="btn_link" placeholder="Exp: {{url('/shop')}}" class="form-control">
           
    </div>
</div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="title">Slider Title</label>
            <input name="title" id="title" value="{{$data->title}}" type="text" class="form-control">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="title_style">Title Font Style</label>
            <input placeholder="Exp. arial" name="title_style" id="title_style" value="{{$data->title_style}}"  type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="title_size">Title Font Size(px)</label>
            <input placeholder="Exp. 50" name="title_size" id="title_size" value="{{$data->title_size}}"  type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="title_color">Title Font Color</label>
            <input placeholder="Exp. #00000" name="title_color" id="title_color" value="{{$data->title_color}}" type="color" class="form-control">
        </div>
    </div>

<div class="col-md-12">
    <div class="form-group">
        <label for="subtitle">Slider Sub Title</label>
        <input placeholder="Enter sub title" name="subtitle" id="subtitle" value="{{$data->subtitle}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="subtitle_style">Font Style</label>
        <input placeholder="Exp. arial" name="subtitle_style" id="subtitle_style" value="{{$data->subtitle_style}}"  type="text" class="form-control">
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="subtitle_size">Font Size(px)</label>
        <input placeholder="Exp. 50" name="subtitle_size" id="subtitle_size" value="{{$data->subtitle_size}}"  type="text" class="form-control">
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="subtitle_color">Font Color</label>
        <input placeholder="Exp. #00000" name="subtitle_color" id="subtitle_color" value="{{$data->subtitle_color}}"  type="color" class="form-control">
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label  for="text_position">Background Color</label>
        <input type="color" class="form-control" name="bg_color" value="{{$data->bg_color}}">
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label  for="text_position">Text Position</label>
        <select class="form-control" name="text_position">
            <option {{($data->text_position == 'left') ? 'selected' : ''}} value="left">Left</option>
            <option {{($data->text_position == 'center') ? 'selected' : ''}} value="center">Center</option>
            <option {{($data->text_position == 'right') ? 'selected' : ''}} value="right">Right</option>
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

