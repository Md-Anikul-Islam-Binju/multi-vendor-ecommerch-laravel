<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="subcategory">Product Attribute Name</label>
        <input name="name" id="subcategory" value="{{$data->name}}" required="" type="text" class="form-control">
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


<div class="col-md-12" >
    <span>Select display type</span>
    <div class="row form-group">
        
        <div class="custom-control custom-checkbox">
            <input @if($data->qty == 1) checked @endif value="1" type="checkbox" id="editqty" name="qty" class="custom-control-input">
            <label class="custom-control-label" for="editqty">Allow Quantity</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input @if($data->price == 1) checked @endif  type="checkbox" id="editprice" name="price" class="custom-control-input">
            <label class="custom-control-label" for="editprice">Allow Price</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input  @if($data->image == 1) checked @endif type="checkbox" id="editimage" name="image" class="custom-control-input">
            <label class="custom-control-label" for="editimage">Allow Image</label>
        </div>

        <div class="custom-control custom-checkbox">
            <input  @if($data->color == 1) checked @endif type="checkbox" id="editcolor" name="color" class="custom-control-input">
            <label class="custom-control-label" for="editcolor">Allow Color</label>
        </div>
    </div>
</div>
<div class="col-md-12 ">
    
    <div class="checkbox2">
        <input @if($data->display_type) checked @endif type="checkbox" id="editdisplayIn" name="displayInrrrr" value="1">
        <label for="editdisplayIn">Allow display in product details.</label>
    </div>      

</div>

<div class="col-md-12" id="editdisplayInDetailsPage" @if(!$data->display_type) style="display: none;" @endif >

    <span>Select display type</span>
    <div class="row form-group">
        
        <div class="custom-control custom-radio">
            <input value="1" type="radio" @if($data->display_type == 1) checked @endif id="editflat" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editflat">Flat</label>
        </div>
        <div class="custom-control custom-radio">
            <input value="2" type="radio" @if($data->display_type == 2) checked @endif id="editselect" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editselect">Select</label>
        </div>
        <div class="custom-control custom-radio">
            <input value="3" @if($data->display_type == 3) checked @endif type="radio" id="editradio" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editradio">Radio</label>
        </div>

        <div class="custom-control custom-radio">
            <input value="4" @if($data->display_type == 4) checked @endif type="radio" id="editdropdown" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editdropdown">Dropdown</label>
        </div>
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

<script type="text/javascript">
        $("#editdisplayIn").change(function() {
        if(this.checked) { $("#editdisplayInDetailsPage").show(); }
        else { $("#editdisplayInDetailsPage").hide(); }
    });
</script>