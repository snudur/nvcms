@if(isset($page))
	<h1>{{ $page->title }}</h1>

	{!! cmsContent($page) !!}

	{{--
	
	<hr>

	<table>
		@foreach($page->file()->all() as $file)
			<tr>
				<td><i class="uk-icon-file-pdf-o"></i> <a href="/files/{{ $file['name'] }}">{{ $file['title'] }}</a></td>
			</tr>
		@endforeach
	</table>

	--}}

	@if(\Request::is('hafa-samband'))
		@include('frontend.forms.contact')
	@endif
@endif