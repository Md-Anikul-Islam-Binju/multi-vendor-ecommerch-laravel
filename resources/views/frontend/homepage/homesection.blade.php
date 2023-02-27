@foreach($sections as $section)
	@if(View::exists('frontend.homepage.'.$section->section_type))
	@include('frontend.homepage.'.$section->section_type)
	@endif
@endforeach 