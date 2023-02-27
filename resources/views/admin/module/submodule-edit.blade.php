<input type="hidden" value="{{$data->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="submodule_name">Module Name</label>
        <input  name="submodule_name" id="submodule_name" value="{{$data->submodule_name}}" required="" type="text" class="form-control">
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="route">Route Name</label>
        <input  name="route" id="route" value="{{$data->route}}" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="sidebar"> <input name="is_hidden_sidebar" @if($data->is_hidden_sidebar == 1) checked @endif  id="sidebar" value="1" type="checkbox"  > Hidden is sidebar</label><br/>
        <label for="role_permission"> <input @if($data->is_hidden_role_permission == 1) checked @endif name="is_hidden_role_permission" id="role_permission" value="1" type="checkbox"  > Hidden is role permission</label>
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

