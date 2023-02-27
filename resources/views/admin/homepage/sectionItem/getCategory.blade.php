@if(count($allCategories)>0)
    @foreach($allCategories as $category) 
      
        <tr id="category{{ $category->id }}"  @if(in_array($category->id, $items_id)) style="background: #ffe2e2" @endif>
            <td><input type="checkbox" class="item_id" name="item_id[{{  $category->id }}]"></td>
            <td><img width="35" src="{{ asset('upload/images/category/'. $category->image)}}" alt=""> {{Str::limit($category->category_bd, 40)}}</td>
            
    
            @if(in_array($category->id, $items_id))
            <td><a href="javascript:void(0)"  class="btn btn-danger btn-sm">Added</a></td>
            @else
             <td><a href="javascript:void(0)"  class="btn btn-success btn-sm" onclick="addcategory({{ $category->id }})">Add</a></td>
            @endif
        </tr>
    @endforeach
    <tr><td colspan="15">{{$allCategories->appends(request()->query())->links()}}</td></tr>

@endif