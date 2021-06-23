@extends('common')

@section('title', 'Log in!')

@section('content')

<div class="row">
    <div class="col-10 offset-1 col-md-6 offset-md-3 mt-5">
      @include('child',['childs' => $tree])
  </div>
</div>

@endsection