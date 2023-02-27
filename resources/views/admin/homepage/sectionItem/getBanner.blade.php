@if(count($allBanners)>0)
    @foreach($allBanners as $banner) 
        @php
            $width = 250/$banner->banner_type;
        @endphp
        <tr id="banner{{ $banner->id }}"  @if(in_array($banner->id, $items_id)) style="background: #ffe2e2" @endif>
            <td><input type="checkbox" class="item_id" name="item_id[{{  $banner->id }}]"></td>
            <td> {{Str::limit($banner->title, 40)}}</td>
            <td style="width: 360px;">
                @if($banner->banner1)
                <img src="{!! asset('upload/images/banner/'. $banner->banner1) !!}" width="{{$width}}">
                @endif
                @if($banner->banner2)
                <img src="{!! asset('upload/images/banner/'. $banner->banner2) !!}" width="{{$width}}">
                @endif
                @if($banner->banner3)
                <img src="{!! asset('upload/images/banner/'. $banner->banner3) !!}" width="{{$width}}">
                @endif @if($banner->banner4)
                <img src="{!! asset('upload/images/banner/'. $banner->banner4) !!}" width="{{$width}}">
                @endif @if($banner->banner5)
                <img src="{!! asset('upload/images/banner/'. $banner->banner5) !!}" width="{{$width}}">
                @endif @if($banner->banner6)
                <img src="{!! asset('upload/images/banner/'. $banner->banner6) !!}" width="{{$width}}">
                @endif
            </td>
    
            @if(in_array($banner->id, $items_id))
            <td><a href="javascript:void(0)"  class="btn btn-danger btn-sm">Added</a></td>
            @else
             <td><a href="javascript:void(0)"  class="btn btn-success btn-sm" onclick="addbanner({{ $banner->id }})">Add</a></td>
            @endif
        </tr>
    @endforeach
    <tr><td colspan="15">{{$allBanners->appends(request()->query())->links()}}</td></tr>

@endif