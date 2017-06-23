@extends('layouts.app')

@section('content')
<div class="row" id="links-container">
	<div class="container-fluid container tagsContainer">
	    @foreach($allLinksWithoutTags as $user)
	    	<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12 ">
	    		{{ Form::checkbox('links', $user->id, null, ['class' => 'linksCheckbox']) }}
	    		<a href="/post/{{ $user->slug }}">{{ $user->title }}</a>
	    	</div>
	    @endforeach
	    <div class="container">
	    	<div class="form-group" id="tagsSelector">
	    		<input type="text" name="tags" id="tags">
	    		<input type="hidden" name="selectedTags" id="selectedTags">
	    	</div>
	    	<div class="form-group">
	    		<button id="saveTags" class="btn-primary">Submit</button>
	    	</div>
	    </div>
    </div>
</div>
@endsection
<script>
var tags = [
    @foreach ($allExistingTags as $tag)
    	{tag: "{{$tag}}" },
    @endforeach
];
</script>

