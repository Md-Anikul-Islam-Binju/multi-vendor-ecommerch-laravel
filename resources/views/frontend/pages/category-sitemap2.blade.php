@extends('layouts.frontend')
@section('title', Config::get('siteSetting.title'))

@section('css')
	   <style type="text/css">
      .tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:2px 18px 4px 45px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span:not(.glyphicon) {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
    display:inline-block;
    padding:4px 0px;
    text-decoration:none
}
.tree li.parent_li>span:not(.glyphicon) {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:not(.glyphicon):hover, .tree li.parent_li>span:not(.glyphicon):hover+ul li span:not(.glyphicon) {
    background:#eee;
    border:1px solid #999;
    padding:3px 8px;
    color:#000
}
   </style>
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>All Categories</li>
                
            </ul>
        </div>
    </div>
    @php $categories = App\Models\Category::where('parent_id', '=', null)->orderBy('orderBy', 'asc')->where('status', 1)->get(); @endphp
    <div class="container">
    <div class="row">
      	<div class="col-md-12">
        	<div id="test" class="tree">
    		   <ul>
    		      	<li class="parent_li">
    		         	<span title="Verkleinern">Website</span>
    		         	<ul>
    		         	@foreach($categories as $category)
    		            <li class="parent_li">
    		               <span title="Verkleinern">{{$category->name}}</span>
    		               @if(count($category->get_subcategory)>0)
    		               <ul>
    		               	@foreach($category->get_subcategory as $subcategory)
    		                  	<li class="parent_li">
    		                     <span title="Verkleinern">{{$subcategory->name}}</span>
    		                     @if(count($subcategory->get_subchild_category)>0)
    		                     <ul>
    		                     	@foreach($subcategory->get_subchild_category as $childcategory)
    		                        <li class="parent_li">
    		                           <span title="Verkleinern">{{$childcategory->name}}</span>
    		                           <ul></ul>
    		                        </li>
    		                        @endforeach
    		                     </ul>
    		                     @endif
    		                  	</li>
    		                @endforeach
    		               </ul>
    		               @endif
    		            </li>
    		            @endforeach
    		         	</ul>
    		      	</li>
    		   </ul>
    		</div>
      	</div>
    </div>
    </div>
@endsection