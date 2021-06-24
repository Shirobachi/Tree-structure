@extends('common')

@section('title', "Move " . $e->title)

@section('content')

    <div class="row">
        <div class="offset-md-4 col-md-4 col-10 offset-1 mt-5">

            <form method="POST" action="{{url('/tree/move')}}">
                @csrf

                <input type="hidden" name="id" value="{{$e->id}}">
                <input type="text" disabled class="form-control mb-3" value="{{$e->title}}">
                <select class="btn-block custom-select form-select" name="newParent">
                @foreach($allElements as $E)
                    @if ($E->id == $e->id)
                        <option selected value="{{$E->id}}">{{$E->title}}</option>
                    @else
                        <option value="{{$E->id}}">{{$E->title}}</option>
                    @endif
                @endforeach
                </select><br>

                <button type="submit" class="btn btn-info mb-2 input-block-level form-control">Move!</button>

            </form>
        </div>
    </div>

@endsection