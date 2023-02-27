@extends('layouts.frontend')
@section('title', 'My Account | '. Config::get('siteSetting.site_name') )

@section('content')
<div class="breadcrumbs">
	<div class="container">
		<ul class="breadcrumb-cate">
		    <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
		    <li><a href="#">My account</a></li>
		 </ul>
	</div>
</div>
<!-- Main Container  -->
<div class="container">

	<div class="row">
		<!--Right Part Start -->
		@include('reseller.inc.sidebar')
		<!--Middle Part Start-->
		<div id="content" class="col-md-9 sticky-conent">
            <table class="table table-sm table-hover" id="myTable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($myCustomer as $mc)
                    <tr>
                        <td>{{ $mc->id }}</td>
                        <td>{{ $mc->name }}</td>
                        <td>{{ $mc->mobile }}</td>
                        <td>{{ $mc->email }}</td>
                        <td>{{ $mc->address }}</td>
                        <td>{{ $mc->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>


		</div>
		<!--Middle Part End-->
	</div>
</div>
<!-- //Main Container -->
@endsection

@section('js')

<script type="text/javascript">
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

	 function get_city(id, type=''){
       
        var  url = '{{route("checkout.get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data.status){
                    $("#show_city"+type).html(data.allcity);
                    $("#show_city"+type).focus();
                }else{
                    $("#show_city"+type).html('<option>City not found</option>');
                }
            }
        });
    }  	 

    function get_area(id, type=''){
           
        var  url = '{{route("get_area", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#show_area"+type).html(data);
                    $("#show_area"+type).focus();
                }else{
                    $("#show_area"+type).html('<option>Area not found</option>');
                }
            }
        });
    }  
</script>
@endsection