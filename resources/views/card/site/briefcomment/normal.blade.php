<div class="card comment-card">	
	<div class="card-header">
		<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
	</div>
	<div class="card-body">
		{{ $briefcomment->message }}
	</div>
   	<div class="card-footer">
   		<div class="card-icons">
   			{{--
   			<a class="btn btn-light" href="#brief-comments">Ответить</a>
   			--}}
   		</div>
   		<div class="card-user">
   			<div class="user-name">
   				<a href="{{ route('site.user.show', ['login' => $briefcomment->user->login]) }}">{{ $briefcomment->user->nickname }}</a>
   				<time>{{ $briefcomment->posted_at->format('d.m.Y H:i') }}</time>
   			</div>
			<div class="user-img">
				<a href="{{ route('site.user.show', ['login' => $briefcomment->user->login]) }}">
					<img src="{{ asset('preview/33/33/storage/users/' . $briefcomment->user->avatar) }}" alt="{{ $briefcomment->user->nickname }}">
				</a>
			</div>
   		</div>
   	</div>
</div>
