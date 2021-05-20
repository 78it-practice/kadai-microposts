@extends('layouts.app')
@section('content')
  @if(Auth::check())
    <h2>{{ Auth::user()->name }}</h2>
  @else
    <div clsas="center jumbotron">
      <div class="text-center">
        <h1>Welcome to the Microposts</h1>
        {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
      </div>
    </div>
  @endif
@endsection
