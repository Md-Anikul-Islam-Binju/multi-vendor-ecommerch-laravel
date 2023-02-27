<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('home.category', $category->slug) }}</loc>
            <lastmod>{{ ($category->updated_at) ? $category->updated_at->tz('UTC')->toAtomString() : Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
       	@if($category->get_subcategory)
        @foreach ($category->get_subcategory as $subcategory)
        <url>
            <loc>{{ route('home.category', [$category->slug, $subcategory->slug]) }}</loc>
            <lastmod>{{ ($subcategory->updated_at) ? $subcategory->updated_at->tz('UTC')->toAtomString() : Carbon\Carbon::now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
        </url>
		@endforeach
       	@endif
    @endforeach
</urlset>