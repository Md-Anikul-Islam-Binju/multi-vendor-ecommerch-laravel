<input type="hidden" value="{{$data->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="module_name">Module Name</label>
        <input  name="module_name" id="module_name" value="{{$data->module_name}}" required="" type="text" class="form-control">
    </div>
</div>
<!-- <div class="col-md-12">
    <div class="form-group">
        <label for="route">Route Name</label>
        <input  name="route" id="route" value="{{$data->route}}" type="text" class="form-control">
    </div>
</div> -->

<div class="col-md-12">
    <div class="form-group">
        <label for="icon">Module Icon</label>
        <input  name="icon" id="icon" value="{{$data->icon}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($data->status == 1 ) ?  'checked' : ''}} type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>

