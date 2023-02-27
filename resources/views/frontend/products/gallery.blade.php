<script type="text/javascript">
	$('.large-image').magnificPopup({
		items: [
			{src: 'http://localhost:8000/frontend/image/catalog/demo/product/travel/2.jpg' },
			{src: 'http://localhost:8000/frontend/image/catalog/demo/product/travel/12.jpg' },
			{src: 'http://localhost:8000/frontend/image/catalog/demo/product/travel/13.jpg' },
		],
		gallery: { enabled: true, preload: [0,2] },
		type: 'image',
		mainClass: 'mfp-fade',
		callbacks: {
			open: function() {
				
				var activeIndex = parseInt($('#thumb-slider .img.active').attr('data-index'));
				var magnificPopup = $.magnificPopup.instance;
				magnificPopup.goTo(activeIndex);
			}
		}
	});
</script>