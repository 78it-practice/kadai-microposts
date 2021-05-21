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
        {{-- ユーザ詳細タブ --}}
        <li class="nav-item">
          {{-- リクエストされたルートがusers.showの場合は.activeをつける --}}
          <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
            TimeLine
            <span class="badge badge-secondary">{{ $user->microposts_count }}</span>
          </a>
        </li>
        {{-- フォロー一覧タブ --}}
        <li class="nav-item">
        </li>
        {{-- フォロワー一覧タブ --}}
        <li class="nav-item">
        </li>
      </ul>
      @if(Auth::id() == $user->id)
        {{-- 投稿フォーム --}}
        @include('microposts.form')
      @endif
      {{-- 投稿一覧 --}}
      @include('microposts.microposts')
    </div>
  </div>
@endsection
