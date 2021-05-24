{{-- 表示中のページが自分のユーザページ以外の場合 --}}
@if(Auth::id() != $user->id)
  @if(Auth::user()->is_following($user->id))
    {{-- フォロー解除ボタン --}}
    {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete']) !!}
      {!! Form::submit('Unfollow', ['class' => 'btn btn-danger btn-block']) !!}
    {!! Form::close() !!}
  @else
    {{-- フォローボタン --}}
    {!! Form::open(['route' => ['user.follow', $user->id]]) !!}
      {!! Form::submit('Follow', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}
  @endif
@endif
