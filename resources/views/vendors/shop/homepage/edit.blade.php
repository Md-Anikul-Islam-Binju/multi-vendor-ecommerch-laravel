<input type="hidden" value="{{$section->id}}" name="id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="required" for="name">Section Title</label>
            <input  name="title" id="name" value="{{$section->title}}" required="" type="text" class="form-control">
        </div>
    </div>
    @if($section->is_default != 1)
    <div class="col-md-6">
        <div class="form-group">
            <label for="name required">Select Type</label>
            <select required onchange="sectionType(this.value, 'edit')" name="section_type" class="form-control">
                <option value="">Selct one</option>
                <option @if($section->type == 'banner') selected @endif value="banner">Banner</option>
                <option  @if($section->type == 'category') selected @endif value="category">Product Category</option>
                <option  @if($section->type == 'section') selected @endif value="section">Pick Products</option>
            </select>
        </div>
    </div>


    <div class="col-md-12" id="editshowSection">

        @if($section->type == 'banner')
            <div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Select Banner</label> <select name="product_id" required="required" id="product_id" class="form-control custom-select"> <option value="">Select banner</option>@foreach($banners as $banner)<option @if($section->product_id == $banner->id) selected @endif value="{{$banner->id}}" > {{$banner->title}}</option>@endforeach</select> </div></div>
        @elseif($section->type== 'category')
            <div class="col-md-12"><div class="form-group"> <label class="required" for="product_id">Product Categories</label> <select name="product_id" id="product_id" class="form-control custom-select"> <option value="">Select category</option>@foreach($categories as $category)<option  @if($section->product_id == $category->id) selected @endif value="{{$category->id}}" > {{$category->name}}</option>@endforeach</select> </div></div>

        @elseif($section->type== 'section')
            <div class="col-md-12"><div class="form-group"> <label for="category">Product Categories</label> <select onchange="getAllProducts(this.value)"  id="category" class="form-control custom-select"> <option value="">Select category</option>@foreach($categories as $category)<option value="{{$category->id}}" > {{$category->name}}</option>@endforeach</select> </div></div>
            <div class="col-md-12"> <div class="form-group"><label for="homepage">Select More Product</label><select  onchange="getProduct(this.value)" id="showAllProducts" class="form-control custom-select" style="width: 100%"><option value="">Select First Category</option></select></div></div>

            <div class="col-md-12"><div class="form-group"><label for="getProducts">Selected Products</label><select required name="product_id[]" id="showSingleProduct" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Choose">
                @foreach($products as $product)
                <option selected value="{{  $product->id }}">{{  $product->title }}</option>
                @endforeach
            </select></div></div>
        @else

       @endif
        
    </div>
    @endif
    <div class="col-md-4">
        <div class="form-group">
            <label class="required" for="name">Bacground Color</label>
            <input name="background_color" value="{{$section->background_color}}" class="form-control gradient-colorpicker">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="required" for="name">Text Color</label>
            <input name="text_color" value="{{$section->text_color}}" class="form-control gradient-colorpicker">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="required">Section Width</label>
            <select name="layout_width" class="form-control">
                <option @if($section->layout_width == null) selected @endif value="box">Box</option>
                <option @if($section->layout_width != null) selected @endif value="full">Full</option>
            </select>
        </div>
    </div>

</div>

                                  

<div class="col-md-12">

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

