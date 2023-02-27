@extends('layouts.frontend')
@section('title', 'Checktout')

@section('content')
    
    <div class="breadcrumbs">
        <div class="container">
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
    </div>
    <a href="javascript:void(0)" class="btn btn-info open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i> Sidebar</a>
    <div class="container product-detail ">
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas sticky-content">
                <span id="close-sidebar" class="fa fa-times"></span>
                <div class="module so_filter_wrap filter-horizontal">
                    <h3 class="modtitle"><span>Category {{$_SERVER['SERVER_NAME']}}</span></h3>
                    <div class="modcontent">
                        <ul>
                        <li class="so-filter-options">
                            <div class="so-filter-content-opts" style="display: block;">
                                    <?php $categories =  \App\Models\Category::where('parent_id', '=', null)->orderBy('orderBy', 'asc')->where('status', 1)->get() ?> 
                                <div class="mod-content box-category">
                                 <ul class="accordion" id="accordion-category">
                                    @foreach($categories as $category )
                                  <li class="panel">
                                    @if($category)<a href="#">{{$category->name}}</a>@endif
                                  
                                  </li>
                                  @endforeach
                                 </ul>
                              </div>
                            </div>
                        </li>
                        </ul>
                    </div>
                </div>
            </aside>
            <div id="content" class="col-sm-9 sticky-content">
                <div class="blog-header">
                    <h3>Simple Blog</h3>
                </div>
                <div class="blog-listitem row">
                      <div class="blog-item col-md-4 col-sm-4 col-xs-6">
                        <div class="blog-item-inner">
                            <div class="itemBlogImg left-block">
                                <div class="article-image banners">
                                    <div>
                                        <a class="popup-gallery" href="{{asset('frontend')}}/image/catalog/demo/blog/5.jpg">
                                        <img src="{{asset('frontend')}}/image/catalog/demo/blog/5.jpg" alt="Baby Came Back! Missed Out? Grab Your">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="itemBlogContent right-block ">
                                <div class="blog-content">
                                    <div class="article-date">
                                        
                                    </div>
                                    <div class="article-title font-title">
                                        <h4><a href="blog-detail.html">Baby came back! missed out? grab your</a></h4>
                                    </div>
                                    <p class="article-description">
                                        Morbi tempus, non ullamcorper euismod, erat odio suscipit purus, nec ornare lacus turpis ac purus. Mauris cursus in mi vel dignissim. Morbi mollis eli...
                                    </p>
                                    <div class="blog-meta">
                                        <span class="author"><span>Post by </span>Tuandt</span> / &nbsp;
                                        <span class="comment_count"><a href="#">0 Comments</a></span>
                                    </div>
                                    <div class="readmore hidden">
                                        <a class="btn-readmore font-title" href="#">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
           
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
