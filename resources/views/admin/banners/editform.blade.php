    <input type="hidden" value="{{$data->id}}" name="id">
    <div class="row">
         <div class="col-md-12">
            <div class="form-group">
                <label class="required" for="title">Banner Title</label>
                <input name="title" id="title" value="{{$data->title}}" type="text" class="form-control">
            </div>
        </div>
      

    <div class="col-md-12">
            <div class="form-group">
                <label for="name required">Select Page</label>
                <select required  name="page_name" class="form-control">
                    <option  value="{{$data->page_name}}">{{$data->title}}</option>
                    @foreach($pages as $page)
                    <option @if($data->page_name == $page->id) selected @endif value="{{$page->id}}">{{$page->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row" id="showBannerImageedit">

        <?php  $width = (1200/$data->banner_type); ?>                                                  
        @for($i=1; $i <= $data->banner_type; $i++)
        @php
        $banner = 'banner'.$i;
        $link = 'btn_link'.$i;
        @endphp
        @if($data->$banner)
        <div class="col-md-{{round(12/$data->banner_type, 0)}}">
            <div class="form-group">
                <label class="required dropify_image">Banner {{$i}}</label>
                <input type="hidden" name="width" value="{{$width}}">
                <span class="image{{$i}}" >
                    <div class="dropify-wrapper" onclick="removeImage('{{$data->id}}', '{{$i}}')">
                        <img src="{{asset('upload/images/banner/'.$data->$banner)}}" style="width: 100%;height: 100%;">
                        <span style="position: absolute;top: 0;right: 0; background: #fff;border: 1px solid #fff;padding: 3px;color: red;">Remove</span>
                    </div>
                </span>
                <p style="color:red;font-size: 10px">Image Size: {{$width}}px * 250px</p> 
                <label class="required" for="btn_link{{$i}}">Link {{$i}}</label>
                <input type="text" value="{{ $data->$link }}" required id="btn_link{{$i}}" name="btn_link{{$i}}" placeholder="Exp: {{url('/')}}" class="form-control">
            </div>
        </div>

        @else
        <div class="col-md-{{12/$data->banner_type}}">
            <div class="form-group">
                <label class="required dropify_image">Banner {{$i}}</label>
                <input type="hidden" name="width" value="{{$width}}'">
                <span class="image{{$i}}" >
                <input type="file" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  name="banner{{$i}}"  class="dropify">
                 
                </span>
                <p style="color:red">Image Size: {{$width}}px * 250px</p> 
                <label class="required" for="btn_link{{$i}}">Link {{$i}}</label>
                <input type="text" required id="btn_link{{$i}}" name="btn_link{{$i}}" placeholder="Exp: {{url('/')}}" class="form-control">
            </div>
        </div>
        @endif
       
     @endfor
</div>

<div class="row justify-content-md-center">
                                        
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
</div>

