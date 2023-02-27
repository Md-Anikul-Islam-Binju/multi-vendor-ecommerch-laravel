<input type="hidden" value="{{ $product_id }}" name="product_id">
@if(count($product_images)>0)
	@foreach($product_images as $product_image)
	<div id="gelImage{{$product_image->id}}" style="width: 60px;height: 60px; float: left;position: relative;border: 1px solid #e6e2e2;
	    margin-right: 3px;">
	    <img style="width: 100%; height: 100%;" src="{{asset('upload/images/product/gallery/thumb/'.$product_image->image_path)}}" >
	    <span title="Delete Gallerry Image" onclick="deleteGallerryImage({{$product_image->id}})" style="cursor: pointer; position: absolute;top: -4px;right: 0;color: red;"><i class="fa fa-times"></i></span>
	</div>
	@endforeach
@else
<i style='color:red'> Gallery image not found. Please upload image.</i>
@endif