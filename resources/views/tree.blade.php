@extends('common')

@section('title', 'Treeview!')

@section('content')

<div class="row">
    <div class="col-10 offset-1 col-md-6 offset-md-3 mt-5">

      @if($info ?? '')
        <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
          <strong>{{$info['title'] ?? ''}}</strong> {{$info['desc'] ?? ''}}
        </div>
      @endif

      @if(App\Models\tree::where('owner', $tree[0]->owner) -> get() -> count() > 1)
        <button id="toggleAll" class="btn btn-info mb-2 input-block-level form-control" type="button">Show all</button>
      @endif
      <div class="accordion">
        @include('child',['childs' => $tree])
    </div>
  </div>
</div>

<script>
  var show = false;

  $('#toggleAll').on('click', function () {
    if(!show){
      $('.collapse').collapse('show');
      $('#toggleAll').html('Hide all');
    }
      else{
        $('#toggleAll').html('Show all');
        $('.collapse').collapse('hide');
      }
      
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

  function _delete(id) {
  var sure = confirm("Are you sure?");
  if (sure)
    window.location.href = '{{url('tree')}}'+ '/' + id + '/delete';
  }

</script>

@endsection