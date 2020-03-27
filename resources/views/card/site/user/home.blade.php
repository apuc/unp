<a class="card user-card" href="{{ route('site.user.show', ['login' => $user->login]) }}">
	<div class="card-body">
		<div class="card-user">
			<div class="user-img">
				@isset($user->avatar)
					<object><a href="{{ route('site.user.show', ['login' => $user->login]) }}">
						<img src="{{ asset('preview/33/33/storage/users/' . $user->avatar) }}" alt="{{ $user->nickname }}">
					</a></object>
				@endisset
			</div>
			<object><a href="{{ route('site.user.show', ['login' => $user->login]) }}" class="user-name">{{ $user->nickname }}</a></object>
		</div>
		<div class="user-profit">
			Прибыль <b><span style="color:{{ $user->stat_profit > 0 ? 'green' : 'red' }};">{{ sprintf("%0.02f", $user->stat_profit) }}%</span></b>
		</div>
	</div>
</a>
