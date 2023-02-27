<input type="hidden" value="{{$data->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="brand">Brand Name</label>
        <input name="name" id="brand" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="name">User Type</label>
        <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
            <option value="">Select user</option>
            <option value="author">Author</option>
            <option value="translator">Translator</option>
            <option value="editor">Editor</option>
            <option value="publisher">Publisher</option>
        </select>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <span for="details">User Details</span>
        <textarea placeholder="Enter user details" name="details" class="form-control" rows="3">{{$data->details}}</textarea>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">User Logo</label>
        <input data-default-file="{{asset('upload/images/brand/'.$data->logo)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="10M"  name="phato" id="input-file-events">
        <p class="upload-info">Logo Size: 95px*95px</p>
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
                <label class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>