@extends('layouts.app')

@section('content')
<div class="row" id="links-container">
	<div class="container-fluid container tagsContainer">
	@foreach($allTags as $tags)
		<?php
			$tagUrl = url('/') . '/tag/' . $tags->slug;
		?>
		<div class="col-xs-6 col-md-3 col-lg-3 col-sm-3 tagsBlock">
		<a href={{ $tagUrl }} class='tag'>
			{{ strtoupper(htmlspecialchars_decode($tags->name)) }} ({{ $tags->count }})
		</a>
		</div>
		
	@endforeach
	</div>
</div>
@endsection
