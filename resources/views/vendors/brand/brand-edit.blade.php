<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="brand">Brand Name</label>
        <input name="name" id="brand" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">                           
    <div class="form-group">
        <label for="category">Select Category</label>
        <select name="category_id" id="category" class="form-control select2 custom-select">
                <option {{(0 == $data->category_id) ?  'selected' : ''}} value="0">All Category</option>
            @foreach($get_category as $category)
                <option value="{{$category->id}}" {{($category->id == $data->category_id) ?  'selected' : ''}}>{{$category->name}}</option>
                @if($category->get_subcategory)
                    @foreach($category->get_subcategory as $subcategory)
                        <option value="{{$subcategory->id}}" {{($subcategory->id == $data->category_id) ?  'selected' : ''}}>--{{$subcategory->name}}</option>
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">Brand Logo</label>
        <input data-default-file="{{asset('upload/images/brand/'.$data->logo)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
        <p class="upload-info">Logo Size: 95px*95px</p>
    </div>
    @if ($errors->has('phato'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('phato') }}
        </span>
    @endif
</div>


