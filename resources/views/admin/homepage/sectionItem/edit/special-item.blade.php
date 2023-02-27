<input type="hidden" value="{{$sectionItem->id}}" name="id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item_title">Section Title</label>
            <input placeholder="Enter Title" name="item_title" id="item_title" value="{{$sectionItem->item_title}}" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="item_sub_title">Sub Title</label>
            <input  name="item_sub_title" placeholder="Enter sub title" id="item_sub_title" value="{{$sectionItem->item_sub_title}}" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group"> 
            <label class="dropify_image">Image</label>
            <input type="file" class="dropify" accept="image/*" data-type='image' data-default-file="{{asset('upload/images/homepage/'.$sectionItem->thumb_image)}}" data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="10M"  name="thumb_image" id="input-file-events">
            <i class="info">Recommended size: 200px*200px</i>
        </div>
        @if ($errors->has('thumb_image'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('thumb_image') }}
            </span>
        @endif
    </div>
	<div class="col-md-12">
	    <div class="form-group">
	        <label class="required" for="name">Custom Url</label>
	        <input name="custom_url" value="{{$sectionItem->custom_url}}" required class="form-control" >
	    </div>
	</div>
 

    <div class="col-md-6">
        <div class="form-group">
            <label class="switch-box">Status</label>
            <div  class="status-btn" >
                <div class="custom-control custom-switch">
                    <input name="status" {{($sectionItem->status == 'active') ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                    <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
                </div>
            </div>
        </div>
    </div>
</div>
                           