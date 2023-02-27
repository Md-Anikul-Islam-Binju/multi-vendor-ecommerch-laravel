<input type="hidden" value="{{$section->id}}" name="id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="required" for="name">Section Title</label>
            <input placeholder="Enter Title" name="title" id="name" value="{{$section->title}}" required="" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="sub_title">Sub Title</label>
            <input  name="sub_title" placeholder="Enter sub title" id="sub_title" value="{{$section->sub_title}}" type="text" class="form-control">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="category_id">Select category</label>
            <select required onchange="getSubcateogry(this.value, 'edit')" name="category_id" id="category_id" class="select2 form-control custom-select">
               <option value="">Select category</option>
               @foreach($categories as $category)
               <option @if($category->id == $section->category_id) selected @endif  value="{{$category->id}}">{{$category->name}}</option>
               @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12" >
        <div class="form-group">
            <label class="required" for="category_id">Sub category</label>
            <select required  name="subcategory_id[]" id="editshowSubcateogry" multiple class="select2 m-b-10 select2-multiple" data-placeholder="Choose" style="width: 100%">
               
               @foreach($subcategories as $subcategory)
                <option @if(in_array($subcategory->id, explode(',', $section->subcategory_id))) selected @endif value="{{$subcategory->id}}">{{$subcategory->name .'('. count($subcategory->productsByChildCategory). ')' }}</option>';
                @if (count($subcategory->get_subchild_category) > 0) {
                @foreach ($subcategory->get_subchild_category as $child_category)
                    <option @if(in_array($child_category->id, explode(',', $section->subcategory_id))) selected @endif value="{{$child_category->id}}">--{{$child_category->name .'('. count($child_category->productsByChildCategory). ')'}} </option>
                @endforeach
                @endif
            @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="required" for="name">Bacground Color</label>
            <input type="text" name="background_color" value="{{$section->background_color}}" class="form-control gradient-colorpicker" >
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="form-group">
            <label class="required" for="name">Text Color</label>
            <input name="text_color" value="{{$section->text_color}}" class="gradient-colorpicker form-control" >
        </div>
    </div>

    <div class="col-md-6">
        <div class="head-label">
            <label class="switch-box">Allow Feature</label>
            <div  class="status-btn" >
                <div class="custom-control custom-switch">
                    <input name="is_feature" checked  type="checkbox" class="custom-control-input" {{($section->is_feature == 1) ?  'checked' : ''}} id="is_feature">
                    <label  class="custom-control-label" for="is_feature">Publish/UnPublish</label>
                </div>
            </div>
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
                           