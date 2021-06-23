@extends('common')

@section('title', 'Treeview!')

@section('content')

<div class="row">
    <div class="col-10 offset-1 col-md-6 offset-md-3 mt-5">
      <button id="toggleAll" class="btn btn-info mb-2 input-block-level form-control" type="button">Toggle all</button>
      <div class="accordion">
        @include('child',['childs' => $tree])
    </div>
  </div>
</div>

<script>
  var show = false;

  $('#toggleAll').on('click', function () {
    if(!show)
      $('.collapse').collapse('show');
      else
        $('.collapse').collapse('hide');
      
    show = !show;
  });

  function _new(id) {
  var name = prompt("Please enter name");
  if (name != null)
    window.location.href = '{{url('tree')}}'+ '/' + id + '/new/' + name;
}

  function _edit(id, oldName) {
  var name = prompt("Please enter new name", oldName);
  if (name != null)
    window.location.href = '{{url('tree')}}'+ '/' + id + '/edit/' + name;
  }

</script>

@endsection