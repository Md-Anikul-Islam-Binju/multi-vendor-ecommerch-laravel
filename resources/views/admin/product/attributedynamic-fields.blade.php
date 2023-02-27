
@foreach($attributes as $attribute)

<?php
    //column divited by attribute field
    if($attribute->qty && $attribute->price && $attribute->color && $attribute->image){
        $col = 2;
    }else{
        $col = 2;
    }

    //set attribute name for js variable & function
    $attribute_fields = str_replace('-', '_', $attribute->slug);
?>
    <div class="col-md-12">
        <!-- Allow attribute checkbox button -->
        <div class="form-group">
            <div class="checkbox2">
                <input type="checkbox" id="check{{$attribute->id}}" name="attribute[{{$attribute->id}}]" value="{{$attribute->name}}">
                <label for="check{{$attribute->id}}">Allow Product {{$attribute->name}}</label>
            </div>
        </div>
        <!--Value fields show & hide by allow checkbox -->
        <div id="attribute{{$attribute->id}}" style="display: none;">

            <div class="row">
                <div class="col-sm-2 nopadding">
                    <div class="form-group">
                        <span class="required">{{$attribute->name}}</span>

                        <select class="form-control select2" name="attributeValue[{{$attribute->id}}][]">
                            @if(count($attribute->get_attrValues)>0)
                                <option value="">Select {{$attribute->name}}</option>
                                @foreach($attribute->get_attrValues as $value)
                                    <option value="{{$value->name}}">{{$value->name}}</option>
                                @endforeach
                            @else
                                <option value="">Value Not Found</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-{{$col}} nopadding">
                    <div class="form-group">
                        <span>SKU</span>
                        <input type="text" class="form-control" name="sku[{{$attribute->id}}][]"  placeholder="SKU">
                    </div>
                </div>
                <!-- check qty weather set or not -->
                @if($attribute->qty)
                <div class="col-sm-1 nopadding">
                    <div class="form-group">
                        <span>Quantity</span>
                        <input type="text" class="form-control"  name="qty[{{$attribute->id}}][]"  placeholder="Qty">
                    </div>
                </div>
                @endif

                <!-- check price weather set or not -->
                @if($attribute->price)
                <div class="col-sm-{{$col}} nopadding">
                    <div class="form-group">
                        <span>Price</span>
                        <input type="text" class="form-control" name="price[{{$attribute->id}}][]"  placeholder="price">
                    </div>
                </div>
                @endif

                @if($attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><span>Select Color</span><input onfocus="(this.type='color')" placeholder="Pick Color" class="form-control"  name="color[{{$attribute->id}}][]" ></div></div>@endif

                <!-- check image weather set or not -->
                @if($attribute->image)
                <div class="col-sm-{{$col}} nopadding">
                    <div class="form-group">
                        <span>Upload Image</span>

                        <div class="input-group">
                            <input type="file" class="form-control" name="image[{{$attribute->id}}][]">
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-1 nopadding" style="padding-top: 20px">
                    <button class="btn btn-success" type="button" onclick="{{$attribute_fields}}_fields();"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div id="{{$attribute_fields}}_fields"></div>
            <div class="row justify-content-md-center"><div class="col-md-4"> <span  style="cursor: pointer;" class="btn btn-info btn-sm" onclick="{{$attribute_fields}}_fields()"><i class="fa fa-plus"></i> Add More {{$attribute->name}}</span></div></div> <hr/>
        </div>

    </div>
    <script type="text/javascript">


    var {{$attribute_fields}} = 1;
    //add dynamic attribute value fields by attribute
    function {{$attribute_fields}}_fields() {

        {{$attribute_fields}}++;
        var objTo = document.getElementById('{{$attribute_fields}}_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "removeclass" + {{$attribute_fields}});
        var rdiv = 'removeclass' + {{$attribute_fields}};
        divtest.innerHTML = '<div class="row"> <div class="col-sm-2 nopadding"> <div class="form-group"> <select class="select2 form-control" name="attributeValue[{{$attribute->id}}][]"> @if(count($attribute->get_attrValues)>0) <option value="">Select {{$attribute->name}}</option> @foreach($attribute->get_attrValues as $value) <option value="{{$value->name}}">{{$value->name}}</option> @endforeach @else <option value="">Value Not Found</option> @endif </select> </div> </div> <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="text" class="form-control" name="sku[{{$attribute->id}}][]"  placeholder="SKU"></div></div> @if($attribute->qty)  <div class="col-sm-1 nopadding"> <div class="form-group"><input type="text" class="form-control"  name="qty[{{$attribute->id}}][]"  placeholder="Qty"></div></div>@endif  @if($attribute->price)  <div class="col-sm-{{$col}} nopadding"><div class="form-group"><input type="number" class="form-control" name="price[{{$attribute->id}}][]"  placeholder="price"></div></div>@endif @if($attribute->color)<div class="col-sm-{{$col}} nopadding"><div class="form-group"><input onfocus="(this.type=\'color\')" placeholder="Pick Color" class="form-control" name="color[{{$attribute->id}}][]"  ></div></div>@endif @if($attribute->image) <div class="col-sm-{{$col}} nopadding"><div class="form-group"><div class="input-group"><input type="file" class="form-control" name="image[{{$attribute->id}}][]"></div></div></div>@endif<div class="col-1"><button class="btn btn-danger" type="button" onclick="remove_{{$attribute_fields}}_fields(' + {{$attribute_fields}} + ');"><i class="fa fa-times"></i></button></div></div>';
            
        objTo.appendChild(divtest);
        $(".select2").select2();
    }
    //remove dynamic extra field
    function remove_{{$attribute_fields}}_fields(rid) {
        $('.removeclass' + rid).remove();
    }

    //Allow checkbox check/uncheck handle
    $("#check"+{{$attribute->id}}).change(function() {
        if(this.checked) {
            $("#attribute"+{{$attribute->id}}).show();
        }
        else
        {
            $("#attribute"+{{$attribute->id}}).hide();

        }
    });

    </script>
@endforeach

