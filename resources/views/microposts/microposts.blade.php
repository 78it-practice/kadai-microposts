@if(count($microposts) > 0)
  <ul class="list-unstyled">
    @foreach($microposts as $micropost)
      <li class="media mb-3">
        <img src="{{ Gravatar::get($micropost->user->email, ['size' => 50]) }}" alt="" class="mr-2 rounded">
        <div class="media-body">
          <div>
            {!! link_to_route('users.show', $micropost->user->name, ['user' => $micropost->user->id]) !!}
            <span class="text-muted">posted at {{ $micropost->created_at }}</span>
          </div>
          <div>
            {{-- 投稿内容 --}}
            <p class="mb-0">
              {!! nl2br(e($micropost->content)) !!}
            </p>
          </div>
          <div>
            {{-- 投稿者が認証済みユーザだった場合 --}}
            @if(Auth::id() == $micropost->user_id)
              {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
              {!! Form::close() !!}
            @endif
          </div>
        </div>
      </li>
    @endforeach
  </ul>
  {{ $microposts->links() }}
@endif
