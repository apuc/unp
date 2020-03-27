<div class="card comment-card">
	<div class="card-header">
		<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
	</div>
	<div class="card-body">
		{{ $forecastcomment->message }}
	</div>
   	<div class="card-footer">
   		<div class="card-icons">
   			{{--
   			<a class="btn btn-light" href="#your-comment">Ответить</a>
   			--}}
   		</div>
   		<div class="card-user">
   			<div class="user-name">
   				<a href="{{ route('site.user.show', ['login' => $forecastcomment->user->login]) }}">{{ $forecastcomment->user->name }}</a>
   				<time>{{ $forecastcomment->posted_at->format('d.m.Y H:i') }}</time>
   			</div>
			<div class="user-img">
				<a href="{{ route('site.user.show', ['login' => $forecastcomment->user->login]) }}">
					<img src="{{ asset('preview/33/33/storage/users/' . $forecastcomment->user->avatar) }}" alt="{{ $forecastcomment->user->nickname }}">
				</a>
			</div>
   		</div>
   	</div>
</div>
