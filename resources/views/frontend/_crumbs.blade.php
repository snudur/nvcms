@if(isset($crumbs) && !empty($crumbs))
	<ul>
		<li><a href="/"><i class="uk-icon-home"></i></a></li>
	
		@foreach($crumbs as $slug => $crumb)
			@if(\Request::path() != ltrim(rtrim($crumb['path'], '/'), '/'))
				<li><a href="{{ $crumb['path'] }}">{{ $crumb['title'] }}</a></li>
			@else
				<li>{{ $crumb['title'] }}</li>
			@endif
		@endforeach
	</ul>
@endif