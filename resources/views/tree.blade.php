@extends('common')

@section('title', 'Treeview!')

@section('content')

<div class="row">
    <div class="col-10 offset-1 col-md-6 offset-md-3 mt-5">
      <div class="accordion">
        @include('child',['childs' => $tree])
    </div>
  </div>
</div>

@endsection