@extends('layout.site.app')

@section('columns')
	<div id="nav">
		@if (!empty($bookmakers))
			<table class="table table-sm bets-table">
				<thead>
					<tr>
						<th class="bookmaker">Букмекер</th>
						<th class="outcomesubtype">1 <span class="active-down"></span></th>
						<th class="outcomesubtype">2 <span class="active-down"></span></th>
					</tr>
					@foreach ($bookmakers as $bookmaker_id => $bookmaker)
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

							@php
								$offer = collect($bookmaker['offers'])->filter(function ($offer) use ($match) {
									return $offer['team_id'] == $match->participants[0]->team_id;
								})->first();
							@endphp
							<td
								data-ss-forecasts-offer-bookmaker-id="{{ $bookmaker_id }}"
								data-ss-forecasts-offer-bookmaker-picture="{{ asset('preview/64/26' . $bookmaker['logo']) }}"
								data-ss-forecasts-offer-bookmaker-name="{{ $bookmaker['name'] }}"
								data-ss-forecasts-offer-outcome-id="{{ $offer['outcome_id'] }}"
								data-ss-forecasts-offer-rate="{{ is_null($offer['odds_current']) ? '0.00' : sprintf('%0.02f', $offer['odds_current']) }}"
								data-ss-forecasts-offer-description="1, {{ $offer['outcometype_name'] }}, {{ $offer['outcomescope_name'] }}"
								class="odds"
							>
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
							</td>

							@php
								$offer = collect($bookmaker['offers'])->filter(function ($offer) use ($match) {
									return $offer['team_id'] == $match->participants[1]->team_id;
								})->first();
							@endphp
							<td
								data-ss-forecasts-offer-bookmaker-id="{{ $bookmaker_id }}"
								data-ss-forecasts-offer-bookmaker-picture="{{ asset('preview/64/26' . $bookmaker['logo']) }}"
								data-ss-forecasts-offer-bookmaker-name="{{ $bookmaker['name'] }}"
								data-ss-forecasts-offer-outcome-id="{{ $offer['outcome_id'] }}"
								data-ss-forecasts-offer-rate="{{ is_null($offer['odds_current']) ? '0.00' : sprintf('%0.02f', $offer['odds_current']) }}"
								data-ss-forecasts-offer-description="2, {{ $offer['outcometype_name'] }}, {{ $offer['outcomescope_name'] }}"
								class="odds"
							>
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
							</td>
						</tr>
					@endforeach
				</thead>
			</table>
		@else
			<p class="text-center pb-3 pt-3">Данных нет</p>
		@endif
	</div>
@endsection