<a class="card user-card" href="{{ route('site.user.show', ['login' => $user->login]) }}">
	<div class="card-header">
		<span class="name"><object><a href="{{ route('site.user.index') }}">Капперы</a></object></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<div class="card-user">
			<div class="user-img">
				@isset($user->avatar)
					<img src="{{ asset('preview/33/33/storage/users/' . $user->avatar) }}" alt="{{ $user->nickname }}">
				@endisset
			</div>
			<object><a class="user-name" href="{{ route('site.user.show', ['login' => $user->login]) }}">{{ $user->login }}</a></object>
		</div>
		<div class="user-card__info">
			<div class="info-row">
				<div class="info-col">Прибыль</div>
				<div class="info-col"><span style="color:{{ $user->stat_profit > 0 ? 'green' : 'red' }}">{{ sprintf("%0.02f", $user->stat_profit) }}%</span></div>
			</div>
			<div class="info-row">
				<div class="info-col">ROI</div>
				<div class="info-col">{{ sprintf("%0.02f", $user->stat_roi) }}% </div>
			</div>
			<div class="info-row">
				<div class="info-col">Прогнозов</div>
				<div class="info-col">{{ $user->stat_forecasts }}</div>
			</div>
			<div class="info-row">
				<div class="info-col"><span style="color:green">В</span> / <span style="color:red">П</span> / <span style="color:#b07d2b">О</span></div>
				<div class="info-col"><span style="color:green">{{ $user->stat_wins }}</span> / <span style="color:red">{{ $user->stat_losses }}</span>  / <span style="color:#b07d2b">{{ $user->stat_draws }}</span></div>
			</div>
			<div class="info-row">
				<div class="info-col">Средний коэф.</div>
				<div class="info-col">{{ sprintf("%0.02f", $user->stat_offer) }}</div>
			</div>
			{{--
			<div class="info-row">
				<div class="info-col">Средняя ставка</div>
				<div class="info-col">{{ $user->stat_bet }}</div>
			</div>
			--}}
			<div class="info-row">
				<div class="info-col">% выигрышей</div>
				<div class="info-col">{{ $user->stat_luck }}%</div>
			</div>
			<div class="info-row">
				<div class="info-col">Банк</div>
				<div class="info-col">{{ $user->balance }}</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<object><a class="btn btn-light" href="{{ route('site.user.show', ['login' => $user->login]) }}">Страница</a></object>
		<object><a class="btn btn-light" href="{{ route('site.forecast.index', ['capper' => $user->login]) }}">Прогнозы</a></object>
	</div>
</a>
