<input type="hidden" value="{{$section->id}}" name="id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="item_title">Section Title</label>
            <input placeholder="Enter Title" name="item_title" id="item_title" value="{{$section->item_title}}" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="sub_item_title">Sub Title</label>
            <input  name="sub_item_title" placeholder="Enter sub title" id="sub_item_title" value="{{$section->sub_item_title}}" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="category_id">Select category</label>
            <select required name="category_id" id="category_id" class="select2 form-control custom-select">
              
               <option value="">Select category</option>
               @foreach($categories as $category)
                    <option  @if($category->id == $section->item_id) selected @endif value="{{$category->id}}">{{$category->category_bd}}</option>
                   
               @endforeach
            </select>
        </div>
    </div>

 
    <div class="col-md-6">
        <div class="form-group">
            <label class="required" for="background_color">Bacground Color</label>
            <input type="text" name="background_color" id="background_color" value="{{$section->background_color}}" class="form-control gradient-colorpicker" >
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="form-group">
            <label class="required" for="name">Text Color</label>
            <input name="text_color" value="{{$section->text_color}}" class="gradient-colorpicker form-control" >
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="switch-box">Status</label>
            <div  class="status-btn" >
                <div class="custom-control custom-switch">
                    <input name="status" {{($section->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                    <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
                </div>
            </div>
        </div>
    </div>
</div>
                           