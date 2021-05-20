@extends('layouts.app')
@section('content')
  <div class="text-center">
    <h1>Sign in</h1>
  </div>
  <div class="row">
    <div class="col-sm6 offset-sm-3">
      {!! Form::open(['route' => 'signup.post']) !!}
        <div class="form-group">
          {!! Form::label('name', 'Name') !!}
          {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('email', 'Email') !!}
          {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('password', 'Password') !!}
          {!! Form::text('password', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('password_confirmation', 'Confirmation') !!}
          {!! Form::text('password_confirmation', null, ['class' => 'form-control']) !!}
        </div>
        {!! Form::submit('Sign up', ['class' => 'btn btn-primary btn-block']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@endsection
