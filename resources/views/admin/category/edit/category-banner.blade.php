<div class="table-responsive">
<p>Banner List</p>
<table  class="table table-bordered table-striped">

<tbody id="positionSorting">
    @foreach($banners as $banner)
    <tr id="banner{{$banner->id}}">
        <td> <img src="{!! asset('upload/images/banner/'. $banner->banner1) !!}" height="100"> </td>
        <td>
            <div class="custom-control custom-switch">
              <input onclick="satusActiveDeactive('banners', {{$banner->id}})"  type="checkbox" {{($banner->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="bannerstatus{{$banner->id}}">
              <label style="padding: 5px 12px" class="custom-control-label" for="bannerstatus{{$banner->id}}"></label>
            </div>
        </td>
        <td>
        <span  onclick="deleteBanner('{{ $banner->id }}')" class="btn btn-danger btn-sm" ><i class="ti-trash" aria-hidden="true"></i> </span>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
</div>