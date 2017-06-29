@extends('layouts.app')
@section('content')
<div class="row" id="links-container">
  <div class="container-fluid container tagsContainer">
    <h4>Redirecting...</h4>
    Click <a href="{{ $urlOfSlug }}">here</a> if you are not automatically redirected
    <?php
      if(env('APP_ENV') != 'local') {
    ?>
    <script>
      ga('send', 'pageview');
    </script>
    <?php
      }
    ?>
    <script type="text/javascript">
      window.location = "{{ $urlOfSlug }}?ref=learnphptoday";
    </script>
  </div>
</div>
@endsection