<div class="card">
  <div class="card-header">
    <h3 class="card-title">{{ $user->name }}</h3>
  </div>
  <div class="card-body">
    {{-- ユーザのメアドでGarvatarの画像を取得して表示 --}}
    <img src="{{ Gravatar::get($user->email, ['size' => 500]) }}" alt="" class="rounded img-fluid">
  </div>
</div>
{{-- フォロー / フォロー解除ボタン --}}
@include('user_follow.follow_button')
