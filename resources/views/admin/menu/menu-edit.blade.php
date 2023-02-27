<input type="hidden" value="{{$data->id}}" name="id">

<!--/row-->
<div class="row justify-content-md-center">
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="name">Menu Name</label>
            <input  name="name" id="name" value="{{$data->name}}" required="" type="text" class="form-control">
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="menu">Menu Source</label>
            <select onchange="getMenuSourch(this.value, 'Edit')" name="menu_type"  required="required" id="menu" class="form-control custom-select">
              
                <option  @if($data->menu_source =='category') selected @endif value="category" > Category</option>
                <option @if($data->menu_source =='page') selected @endif value="page" >Page</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="menu">Source Path</label>
            <select required name="source_id[]" id="showMenuSourchEdit" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                <?php
                    $source_id = explode(",", $data->source_id);
                ?>
                @if($data->menu_source =='category')
                @foreach ($getSources as $source)
                    <option @if(in_array($source->id, $source_id)) selected @endif value="{{$source->id}}">{{$source->name}}</option>

                    @foreach($source->get_subcategory as $childcategory)
                        <option @if(in_array($childcategory->id, $source_id)) selected @endif  value="{{$childcategory->id}}">&nbsp;&nbsp;-{{$childcategory->name}}</option>

                    @endforeach
                @endforeach
                @else
                @foreach ($getSources as $source)
                    <option @if(in_array($source->id, $source_id)) selected @endif value="{{$source->id}}">{{$source->title}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<!--/row-->
<div class="row justify-content-md-center">
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="menu">Menu Display In</label>
            <div class="custom-control custom-checkbox">
                <input @if($data->top_header == 1)) checked @endif  type="checkbox" id="edittop_header" value="top_header" name="top_header" class="custom-control-input">
                <label class="custom-control-label" for="edittop_header">Top Header </label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" @if($data->main_header == 1)) checked @endif   id="editmain_header" value="main_header" name="main_header" class="custom-control-input">
                <label class="custom-control-label" for="editmain_header">Main Header</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="editshow_footer"  @if($data->footer == 1)) checked @endif  value="footer" name="footer" class="custom-control-input">
                <label class="custom-control-label" for="editshow_footer">Footer Menu</label>
            </div>
        </div>
    </div>
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

