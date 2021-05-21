@extends('layouts.app')
@section('content')
  <div class="row">
    <aside class="col-sm-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $user->name }}</h3>
        </div>
        <div class="card-body">
          {{-- ユーザのメアドでGarvatarの画像を取得して表示 --}}
          <img src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="" class="rounded img-fluid">
        </div>
      </div>
    </aside>
    <div class="col-sm-8">
      <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a href="#" class="nav-link">TimeLine</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Followings</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Followers</a></li>
      </ul>
    </div>
  </div>
@endsection
