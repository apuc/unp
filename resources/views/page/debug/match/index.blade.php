@extends('layout.site.debug')

@section('content')

	<form action="{{ route('debug.match.index') }}" method="get">
		<input type="text" data-mask="9999-99-99" data-mask-handler="integer" name="started_at" value="{{ request()->started_at }}">
		<input type="submit">
	</form>

	@if ($dataset->count())
		@foreach ($dataset as $data)
			<h2>{{ $data['sport']->name }} ({{ $data['sport']->main_name }})</h2>

			@foreach ($data['tournaments'] as $tournament)
				<h4>{{ $tournament['tournament']->name ?? $tournament['tournament']->external_name }} ({{ $tournament['tournament']->main_name }})</h3>

				@foreach ($tournament['matches'] as $match)
					<div>
						<a href="{{ route('debug.match.show', ['match' => $match->id]) }}" target="_blank">{{ $match->name ?? $match->external_name }}</a>
						/ {{ $match->bookmaker1_name }} 1: {{ $match->odds1_current ?? '0.00' }}
						/ {{ $match->bookmakerx_name }} X: {{ $match->oddsx_current ?? '0.00' }}
						/ {{ $match->bookmaker2_name }} 2: {{ $match->odds2_current ?? '0.00' }}
					</div>
				@endforeach
			@endforeach
		@endforeach
	@endif

@endsection

