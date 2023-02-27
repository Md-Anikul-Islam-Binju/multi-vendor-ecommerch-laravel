<?php
$products = App\Models\Product::whereIn('id', explode(',', $section->product_id))->orderBy('position', 'asc')->take(10)->get(); 

?>
@if(count($products)>0)
<section class="section" @if($section->layout_width == 1) style="background:{{$section->background_color}}" @endif>
  <div class="container" @if($section->layout_width != 1) style="background:{{$section->background_color}};border-radius: 5px; padding:5px;" @endif>
    
	<div class="row">
	  
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="module so-latest-blog custom-ourblog clearfix default-nav preset01-2 preset02-2 preset03-2 preset04-2 preset05-1">
				<div class="nav nav-tabs">
		          <span class="title">{{$section->title}}</span> 
		          <span class="moreBtn"><a href="{{route('moreProducts', $section->slug)}}">See More</a></span>
		        </div>
				<div class="modcontent">
				<div id="so_latest_blog_1" class="so-blog-external button-type2 button-type2">
					<div class="category-slider-inner products-list yt-content-slider blog-external clearfix " data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column00="2" data-items_column0="2" data-items_column1="2" data-items_column2="2"  data-items_column3="2" data-items_column4="1" data-arrows="no" data-pagination="yes" data-lazyload="yes" data-loop="yes" data-hoverpause="yes">
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="blog-detail.html" target="_self">
							<img src="{{'frontend'}}/image/catalog/demo/blog/8-260x190.jpg" alt="Aestibulum ipsum a ornare car">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Aestibulum ipsum a ornare car" target="_self">Aestibulum ipsum a ornare car</a>
							</h4>
							<div class="description">
								Morbi tempus, non ullamcorper euismod, erat odio suscipit purus, nec ornare lacus turpis ac purus. Mauris cursus in mi v..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="blog-detail.html" target="_self">
							<img src="{{'frontend'}}/image/catalog/demo/blog/9-260x190.jpg" alt="Aestibulum ipsum a ornare lectus">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Aestibulum ipsum a ornare lectus" target="_self">Aestibulum ipsum a ornare lectus</a>
							</h4>
							<div class="description">
								Morbi tempus, non ullamcorper euismod, erat odio suscipit purus, nec ornare lacus turpis ac purus. Mauris cursus in mi v..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="product.html" target="_self">
							<img src="{{'frontend'}}/image/catalog/demo/blog/5-260x190.jpg" alt="Baby Came Back! Missed Out? Grab Your">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Baby Came Back! Missed Out? Grab Your" target="_self">Baby Came Back! Missed Out? Grab Your</a>
							</h4>
							<div class="description">
								Morbi tempus, non ullamcorper euismod, erat odio suscipit purus, nec ornare lacus turpis ac purus. Mauris cursus in mi v..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="blog-detail.html" target="_self">
							<img src="{{'frontend'}}/image/catalog/demo/blog/2-260x190.jpg" alt="Biten demonstraverunt lector ">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Biten demonstraverunt lector " target="_self">Biten demonstraverunt lector </a>
							</h4>
							<div class="description">
								Morbi tempus, non ullamcorper euismod, erat odio suscipit purus, nec ornare lacus turpis ac purus. Mauris cursus in mi v..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="blog-detail.html" target="_self">
							<img src="{{'frontend'}}/image/catalog/demo/blog/7-260x190.jpg" alt="Commodo laoreet semper">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Commodo laoreet semper" target="_self">Commodo laoreet semper</a>
							</h4>
							<div class="description">
								Commodo laoreet semper tincidunt lorem Vestibulum nunc at In Curabitur magna. Euismod euismod Suspendisse tortor ante ad..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					<div class="media">
						<div class="item head-button">
						<div class="content-img col-sm-6 col-xs-12">
							<a href="blog-detail.html" target="_self">
							<img src="image/catalog/demo/blog/3-260x190.jpg" alt="Neque porro quisquam est">
							</a>
						</div>
						<div class="content-detail col-sm-6 col-xs-12">
							<div class="media-content so-block">
							<div class="entry-date font-ct date-bottom">
								<span class="media-date-added"><i class="fa fa-clock-o"></i> 17 Oct 2017</span>
							</div>
							<h4 class="media-heading head-item">
								<a href="blog-detail.html" title="Neque porro quisquam est" target="_self">Neque porro quisquam est</a>
							</h4>
							<div class="description">
								Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius ..
							</div>
							<div class="readmore">
								<a href="blog-detail.html" target="_self">Read more</a>
							</div>
							</div>
						</div>
						</div>
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	
	</div>
</div>
</section>
@endif