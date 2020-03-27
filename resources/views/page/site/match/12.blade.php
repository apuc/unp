@extends('layout.site.app')

@section('columns')
	<div id="nav">
		@if (!empty($bookmakers))
			<table class="table table-sm bets-table">
				<thead>
					<tr>
						<th class="bookmaker">Букмекер</th>
						<th>Бонусы</th>
						<th class="outcomesubtype">1 <span class="active-down"></span></th>
						<th class="outcomesubtype">2 <span class="active-down"></span></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($bookmakers as $bookmaker)
						<tr>
							<td class="bookmaker">
								<a href="{{ $bookmaker['site'] }}" target="_blank" rel="nofollow">
									@if (null !== $bookmaker['logo'])
										<img src="{{ asset('preview/64/26' . $bookmaker['logo']) }}" alt="{{ $bookmaker['name'] }}">
									@else
										{{ $bookmaker['name'] }}
									@endif
								</a>
							</td>
							<td>
								@if ($bookmaker['bonus'] > 0)
									<a href="{{ $bookmaker['site'] }}" target="_blank" rel="nofollow">
										<span class="deal">{{ $bookmaker['bonus'] }}</span>
									</a>
								@else
									&nbsp;
								@endif
							</td>
							<td class="odds">
								@php
									$offer = collect($bookmaker['offers'])->filter(function ($offer) use ($match) {
										return $offer['team_id'] == $match->participants[0]->team_id;
									})->first();
								@endphp
								<a href="{{ $bookmaker['site'] }}" target="_blank" rel="nofollow">
    								<{{ ($offer['has_offers'] ? 'span' : 'strike') }}
    									class="
    										@if ($offer['odds_current'] > $offer['odds_old'])
    											up
    										@elseif ($offer['odds_current'] < $offer['odds_old'])
    											down
    										@endif
    									"
    									data-toggle="tooltip"
    									data-placement="bottom"
    									@if ($offer['odds_current'] != $offer['odds_old'])
    										title="{{ is_null($offer['odds_old']) ? '0.00' : sprintf("%0.02f", $offer['odds_old']) }} &raquo; {{ is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current']) }}"
    									@endif
    								>
    									{{ is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current']) }}
    								</{{ ($offer['has_offers'] ? 'span' : 'strike') }}>
								</a>
							</td>

							<td class="odds">
								@php
									$offer = collect($bookmaker['offers'])->filter(function ($offer) use ($match) {
										return $offer['team_id'] == $match->participants[1]->team_id;
									})->first();
								@endphp
								<a href="{{ $bookmaker['site'] }}" target="_blank" rel="nofollow">
    								<{{ ($offer['has_offers'] ? 'span' : 'strike') }}
    									class="
    										@if ($offer['odds_current'] > $offer['odds_old'])
    											up
    										@elseif ($offer['odds_current'] < $offer['odds_old'])
    											down
    										@endif
    									"
    									data-toggle="tooltip"
    									data-placement="bottom"
    									@if ($offer['odds_current'] != $offer['odds_old'])
    										title="{{ is_null($offer['odds_old']) ? '0.00' : sprintf("%0.02f", $offer['odds_old']) }} &raquo; {{ is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current']) }}"
    									@endif
    								>
    									{{ is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current']) }}
    								</{{ ($offer['has_offers'] ? 'span' : 'strike') }}>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@if ($match->started_at->timestamp > now()->addMinutes(config('forecast.time'))->timestamp)
				<div class="text-center pb-3">
					<a href="{{
						route('account.forecast.create', [
							'sport_id'		=> $match->stage->season->tournament->sport->id,
							'tournament_id'	=> $match->stage->season->tournament->id,
							'match_id'		=> $match->id,
							'type'			=> $type,
							'scope'			=> $scope,
						])
					}}" class="btn btn-primary">Сделать прогноз</a>
				</div>
			@endif

		@else
			<p class="text-center pb-3 pt-3">Данных нет</p>
		@endif
	</div>
@endsection