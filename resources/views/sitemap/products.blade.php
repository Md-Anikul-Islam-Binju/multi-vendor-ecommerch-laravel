<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($products as $product)
        <url>
            <loc>{{ route('product_details', $product->slug) }}</loc>
            <image:image>
			<image:loc>{{asset('upload/images/product/'.$product->feature_image) }}</image:loc>
			</image:image>
            <lastmod>{{ ($product->updated_at) ? $product->updated_at->tz('UTC')->toAtomString() : Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>