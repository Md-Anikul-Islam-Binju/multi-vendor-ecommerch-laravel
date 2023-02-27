@extends('layouts.admin-master')
@section('title', 'Review Details')
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
 
    <style type="text/css">
           
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
    </style>
@endsection
@section('content')
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Review </h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Review</li>
                            </ol>
                            <a href="{{route('adminReviewList')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Review List</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="row">
                                
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
                                    
                                    <div class="card-body p-t-0">
                                        <div class="card b-all shadow-none">
                                            <div class="card-body">
                                                <div class="d-flex ">
                                                    <div>
                                                        <a href="{{ route('product_details', $review->slug) }}"><img src="{{asset('upload/images/product/thumb/'. $review->feature_image)}}" width="40"> {{$review->product_name}}</a><br/>

                                                        
                                                        <div class="p-l-10">
                                                            <h4 class="m-b-0">{{$review->customer_name}} <i class="fa fa-clock">  {{ Carbon\Carbon::parse($review->created_at)->format(Config::get('siteSetting.date_format')) }}
                                                            {{ Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</i></h4>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="card-body">
                                                {!! $review->review !!}
                                            </div>
                                            <div>
                                                <hr class="m-t-0">
                                            </div>
                                            
                                            <div class="card-body">
                                                <h4><i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments <span>({{count($review->review_image_video)}})</span></h4>
                                                <div class="row">
                                                    @foreach($review->review_image_video as $image_video)
                                                 
                                                        @if( $image_video->review_image)
                                                            <div class="col-md-2">
                                                              <a  style="display: inline-flex;" class="popup-gallery single-review" href="{{asset('upload/review/'.$image_video->review_image)}}">
                                                                <img  width="70" height="70" src="{{asset('upload/review/'.$image_video->review_image)}}" alt="">
                                                              </a>
                                                            </div>
                                                          @endif

                                                          @if( $image_video->review_video)
                                                          <div class="col-md-2">
                                                                <a href="#" style="position: relative;display: inline-flex;    align-items: center; background: #e2dfdf;width: 70px;height: 70px;" class="single-review video-btn" data-toggle="modal" data-type="video" data-src="{{asset('upload/review/'.$image_video->review_video)}}" data-target="#video_pop">
                                                                  <span style="position: absolute;text-align: center;    width: 100%;font-size: 45px;"><i class="fa fa-play-circle"></i></span>
                                                                </a>
                                                            </div>
                                                          @endif
                                                    @endforeach
                                                </div>
                                                <div class="b-all m-t-20 p-20">
                                                    <p class="p-b-20">click here to <a href="javascript:void(0)">Reply</a> or <a href="javascript:void(0)">Forward</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page Content -->
             
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('adminReviewUpdate')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update review</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    <div class="modal fade" id="video_pop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content" style="background-color: inherit;border:none;box-shadow: none;">
         <div class="modal-body">        
              <button style="background: #bdbdbd;color:#f90101;opacity: 1;padding: 0 5px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>        
               <!-- 16:9 aspect ratio -->
               <div id="showVideoFrame"></div>                
         </div>        
       </div>
     </div>
</div>
    <!-- delete Modal -->
    @include('admin.modal.delete-modal')

@endsection
@section('js')

<script type="text/javascript">
    $(document).ready(function() {  
         // Gets the video src from the data-src on each button    
        var $videoSrc;  
        $('.video-btn').click(function() {
           
            $videoType = $(this).data( "type" ); 
            $videoSrc = $(this).data( "src" )
            if($videoType == 'video'){
                $('#showVideoFrame').html('<video id="myVideo" width="100%" controls autoplay><source id="video" src="'+ $videoSrc+'" type="video/mp4"></video>');
            }
            if($videoType == 'youtube'){
                $('#showVideoFrame').html( '<iframe width="100%" src="'+ $videoSrc+'?autoplay=1&rel=0'+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'); 
            }
        });
     
        // stop playing the video when I close the modal
        $('#video_pop').on('hidden.bs.modal', function (e) {
           $('#showVideoFrame').html('');
        });
   
    }); 
</script>


    <script type="text/javascript">
  
    function edit(id){
        $('#edit_form').html('<div class="loadingData"></div>');
        var  url = '{{route("adminReviewEdit", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#edit_form").html(data);
                    $('.dropify').dropify();
                }
            },
            // $ID Error display id name
            @include('common.ajaxError', ['ID' => 'edit_form'])

        });
    }


</script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
    </script>

@endsection
