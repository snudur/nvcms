@if(isset($page))
	{{ $page->title }} | {{ config('formable.site_title') }}
@else
	{{ config('formable.site_title') }}
@endif