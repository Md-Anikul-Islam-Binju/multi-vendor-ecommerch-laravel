<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="Feature">Product Feature Name</label>
        <input name="name" id="Feature" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">                           
    <div class="form-group">
        <label for="category">Select Category</label>
        <select name="category_id" id="category_id" class="form-control custom-select">
                <option @if($data->category_id == 'all') selected @endif value="all">All Category</option>
             @foreach($get_category as $category)
                <option value="{{$category->id}}" {{($category->id == $data->category_id) ?  'selected' : ''}}>{{$category->name}}</option>
                @if($category->get_subcategory)
                    @foreach($category->get_subcategory as $subcategory)
                        <option value="{{$subcategory->id}}" {{($subcategory->id == $data->category_id) ?  'selected' : ''}}>--{{$subcategory->name}}</option>
                         <!-- get sub childcategory -->
                        @if($subcategory->get_subcategory)
                        
                            @foreach($subcategory->get_subcategory as $subchildcategory)
                           
                                <option {{($subchildcategory->id == $data->category_id) ?  'selected' : ''}} value="{{$subchildcategory->id}}"> &nbsp;---{{$subchildcategory->name}}</option>
                            
                            @endforeach
                        
                        @endif
                        <!-- end sub childcatgory -->
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">

    <input @if($data->is_required) checked @endif name="is_required" id="is_required" type="checkbox" > <label for="is_required"> Is Requird</label>
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
