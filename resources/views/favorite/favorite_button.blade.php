@if(Auth::user()->is_favorited($micropost->id))
  {{-- お気に入り解除ボタン --}}
  {!! Form::open(['route' => ['favorites.unfavorite', $micropost->id], 'method' => 'delete']) !!}
    {!! Form::submit('Unfavorite', ['class' => 'btn btn-light']) !!}
  {!! Form::close() !!}
@else
  {{-- お気に入り登録ボタン --}}
  {!! Form::open(['route' => ['favorites.favorite', $micropost->id]]) !!}
    {!! Form::submit('Favorite', ['class' => 'btn btn-secondary']) !!}
  {!! Form::close() !!}
@endif
