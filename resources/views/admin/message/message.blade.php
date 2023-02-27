@extends('layouts.admin-master')
@section('title', 'Message list')
@section('css-top')
	<link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('css')}}/pages/chat-app-page.css" rel="stylesheet">
@endsection
@section('css')
<style type="text/css">
.chat-main-header{border-bottom: 1px solid #ccc;background: linear-gradient(179deg, #d6d6d6, #0000000d); padding: 4px;}
.chatonline .avatar { margin-right: 10px; width:35px; height: 35px; -webkit-border-radius: 50%; -moz-border-radius: 50%; border-radius: 50%; position: relative; -ms-flex-nagative: 0; flex-shrink: 0;}
.chatonline .avatar img { width:35px; height: 35px;}
.dot-status:before { position: absolute; content: "";  bottom: 0; right: 0; height: 12px; width: 12px;  background-color: #eee;  display: block;  border: 2px solid #fff; box-shadow: 0 1px 3px rgb(0 0 0 / 20%); -webkit-border-radius: 50%; -moz-border-radius: 50%; border-radius: 50%;}
.online-active:before {  background-color: #51be78 !important;}
.chatonline .content { width: -webkit-calc(100% - 55px);width: -moz-calc(100% - 55px);width: calc(100% - 55px); text-align: left;}
.chatonline .content .text { font-size: 12px;color: #233d63;line-height: 18px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin-bottom: 0px;}
.time{ font-size: 11px;color: #7f8897 !important;margin-bottom: 0;}
.message-box{ background: rgba(127, 136, 151, 0.1);border-radius: 50px;height: 50px; width: 100%;padding: 10px;resize: none;}
.submit-btn { background-color: transparent;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%; width: 40px; height: 40px;line-height: 40px;font-size: 20px;outline: none;right: 12px;position: absolute;top: 50%;-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%); -ms-transform: translateY(-50%);-o-transform: translateY(-50%);transform: translateY(-50%);border: none;color: #7f8897;font-size: 20px;}
/*chrome, opere, safari*/
.message-box::-webkit-scrollbar{ display: none;}
/*firefox, ID Edge*/
.message-box{-ms-overflow-style:none; scrollbar-width:none;}
.active{background: #f8f9fa;}
</style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
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
                    <h4 class="text-themecolor">Message List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Message</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <button data-toggle="modal" data-target="#add" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-pencil-alt"></i> Write New Message</button>
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
                <div class="col-12">
                    <div class="card m-b-0">
                        <!-- .chat-row -->
                        <div class="chat-main-box">
                            <!-- .chat-left-panel -->
                            <div class="chat-left-aside">
                                <div class="open-panel"><i class="ti-angle-right"></i></div>
                                <div class="chat-left-inner">
                                    <div class="form-material">
                                        <input class="form-control p-2 search" id="userKey" onkeyup="myFunction()" type="text" placeholder="Search Contact">
                                    </div>
                                    <ul class="chatonline style-none contacts" id="user-lists">
                                        <li>
                                            <a onclick="message(2)" style="display: flex;" href="javascript:void(0)">
                                            	<div class="avatar dot-status online-active">
                                            		<img src="{{asset('assets')}}/images/users/1673487498.jpg" alt="user-img" class="img-circle">
                                            	</div>
                                            	<div class="content">
                                                    <span>Michelle Moreno </span>
                                                    <p class="text">John, I know everything! Michelle Michelle Michelle</p>
                                                    <i class="time">Yesterday</i>
                                                </div> 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><img src="{{asset('assets')}}/images/users/1673487498.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><img src="{{asset('assets')}}/images/users/1673487498.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)"><img src="{{asset('assets')}}/images/users/1673487498.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                        </li>
                                        
                                        <li class="p-20"></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- .chat-left-panel -->
                            <!-- .chat-right-panel -->
                            <div class="chat-right-aside conversation-history">
                                @include('admin.message.conversations')
                            </div>
                            <!-- .chat-right-panel -->
                        </div>
                        <!-- /.chat-row -->
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- update Modal -->
    <div class="modal fade" id="add" role="dialog" style="display: none;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-pencil-alt"></i> Write New Message</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="" enctype="multipart/form-data" method="POST">
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span for="name">Recipient</span>
                                            <select required name="parent_id" class="select2 form-control custom-select">
                                                <option value="">Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="notes">Message</label>
                                            <textarea name="message" class="form-control" placeholder="Write your message" id="message" rows="3">{{old('message')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Send message</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   	<!-- delete Modal -->
   	@include('admin.modal.delete-modal')

@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('js')}}/pages/chat.js"></script>
	<script>
	    
	    var username = '{{ (Request::route("username")) ?  Request::route("username") : ""}}';
	    
	    $(document).ready(function(){
	        if(username){
	            message(username);
	        }
	    });
	       
	    function message(username){
	       
	        $('.contacts li').click(function() {
	            $(this).addClass('active').siblings().removeClass('active');
	        });   
	        var  link = '<?php echo URL::to("dashboard/getmessages/");?>/'+username;
	        $('.conversation-history').html('<div id="overlay" style="" ></div>');
	        $.ajax({
	            url:link,
	            method:"get",
	            success:function(data){
	                if(data){
	                    $('.conversation-history').html(data);
	               	}else{
	                    $('.conversation-history').html('<p>No Conversation </p>');
	               	}
	            },
	            // $ID Error display id name
	            @include('common.ajaxError', ['ID' => 'edit_form'])
	        });
	        
	        //document.getElementById(username).style.backgroundColor = 'white';
	        var path = "{{route('messageAdmin')}}/"+username;
	        history.pushState(null, null, path);

	    }
	</script>

    <script type="text/javascript">
       $(".select2").select2();
        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("userKey");
            filter = input.value.toUpperCase();
            ul = document.getElementById("user-lists");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("span")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
@endsection
