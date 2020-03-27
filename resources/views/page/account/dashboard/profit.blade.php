@extends('layout.site.app')

@section('columns')
	<div data-ss-profits-content>
		@if ($profits->count())
			<div class="card">
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<tr>
							<th>Период</th>
							<th>Прибыль</th>
							<th>Прогнозов</th>
							<th>Выиграл</th>
							<th>Проиграл</th>
							<th>Отменил</th>
							<th>Средний кэф</th>
							<th>%выигрышей</th>
							<th>ROI</th>
						</tr>
						@foreach ($profits as $month => $profit)
							@if (null !== $profit)
								<tr>
									<td>@lang('months.' . now()->parse($month . '-01')->format('m')) {{ now()->parse($month . '-01')->format('Y') }}</td>
									<td>{{ $profit['profit'] }}%</td>
									<td>{{ $profit['forecasts'] }}</td>
									<td>{{ $profit['wins'] }}</td>
									<td>{{ $profit['losess'] }}</td>
									<td>{{ $profit['draws'] }}</td>
									<td>{{ $profit['offer'] }}</td>
									<td>{{ $profit['luck'] }}%</td>
									<td>{{ $profit['roi'] }}%</td>
								</tr>
							@else
								<tr>
									<td>@lang('months.' . now()->parse($month . '-01')->format('m')) {{ now()->parse($month . '-01')->format('Y') }}</td>
									<td colspan="8" class="text-center">Данных нет</td>
								</tr>

							@endif
						@endforeach
					</table>
				</div>
			</div>
		@endif
	</div>
@endsection
