@extends('common')

@section('title', 'Log in!')

@section('content')

    <div class="row">
        <div class="offset-md-4 col-md-4 col-10 offset-1 mt-5">
            <form method="POST" action="{{url('register')}}">
                @csrf
                <input name="login" type="text" placeholder="Login" class="form-control mb-3">
                <input name="e-mail" type="email" placeholder="E-mail" class="form-control mb-3">
                <input name="password" type="password" placeholder="Password" class="form-control mb-3">
                <input name="password2" type="password" placeholder="Re-type password" class="form-control mb-3">
                <button type="submit" class="btn btn-primary">Register!</button>
                <a class="link-success" href="{{url('/')}}">Login now!</a>
            </form>
        </div>
    </div>

@endsection