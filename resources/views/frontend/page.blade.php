@extends('frontend.layout')

@section('content')

	<?php

	$rootPage = \App\Page::whereSlug(\Request::segment(1))->first();

	?>

	<div class="Page padded">
		<div class="Page__crumbs padded-bottom">
			<div class="uk-container uk-container-center">
				<div class="uk-width-1-1">
					@include('frontend._crumbs', ['crumbs' => $crumbs])
				</div>
			</div>
		</div>
		<div class="uk-container uk-container-center">
			@if($rootPage->hasSubs())
				<div class="uk-grid" data-uk-grid-margin data-uk-grid-match>
					<div class="uk-width-large-1-5 uk-width-medium-1-4">
						<div class="Subnav">
							@include('frontend._subnav')
						</div>
					</div>

					<div class="uk-width-large-4-5 uk-width-medium-3-4">
						@include('frontend._page', ['page' => $page])
					</div>
				</div>
			@else
				@include('frontend._page', ['page' => $page])
			@endif
		</div>
	</div>
	
@stop