@if(count($allItems)>0)
    @foreach($allItems as $item) 
      
        <tr id="item{{ $item->id }}"  @if(in_array($item->id, $items_id)) style="background: #ffe2e2" @endif>
            <td><input type="checkbox" class="item_id" name="item_id[{{  $item->id }}]"></td>
            <td><a style="color: #000" target="_blank" href="{{ route('news_details', $item->news_slug) }}"><img alt="" width="35" src="{{ asset('upload/images/thumb_img/'. $item->source_path)}}"> {{Str::limit($item->news_title, 40)}}</a></td>
            <td>0</td>
            <td>{{ Config::get('siteSetting.currency_symble') . $item->price }}</td>
            <td>{{$item->price_type}}</td>
    
            @if(in_array($item->id, $items_id))
            <td><a href="javascript:void(0)"  class="btn btn-danger btn-sm">Added</a></td>
            @else
             <td><a href="javascript:void(0)"  class="btn btn-success btn-sm" onclick="addnews({{ $item->id }})">Add</a></td>
            @endif
        </tr>
    @endforeach
    <tr><td colspan="15">{{$allItems->appends(request()->query())->links()}}</td></tr>

@endif