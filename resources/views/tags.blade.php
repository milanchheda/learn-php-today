@extends('layouts.app')

@section('content')
<div class="row" id="links-container">
	<div class="container-fluid container">
	@foreach($allTags as $tags)
		<?php
			$tagUrl = url('/') . '/tag/' . $tags->slug;
		?>
		<div class="col-xs-12 col-md-2 col-lg-2 col-sm-2 tagsBlock">
		<a href={{ $tagUrl }} class='tag'>
			{{ strtoupper($tags->name) }} ({{ $tags->count }})
		</a>
		</div>
		
	@endforeach
	</div>
</div>
@endsection
