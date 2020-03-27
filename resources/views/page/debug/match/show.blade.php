@extends('layout.site.debug')

@section('content')

	<h1>{{ $match->team1_name }} {{ $match->score1 }}:{{ $match->score2 }} {{ $match->team2_name }}</h1>
	<div><strong>Турнир:</strong> {{ $match->tournament_name }}</div>
	<div><strong>Начало:</strong> {{ $match->startdate }}</div>
	<div><strong>Статус:</strong> {{ $match->status_type }}</div>

	{{-- 1 x 2 --}}
	@if ($outcomes->get('1x2')['ord']->count() || $outcomes->get('1x2')['1h']->count() || $outcomes->get('1x2')['2h']->count())
		<h2>1x2</h2>

		@if ($outcomes->get('1x2')['ord']->count())
			<h3>Осн. время</h3>
			@foreach ($outcomes->get('1x2')['ord'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / X: {{ $bookmaker['offers']->get(0)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('1x2')['1h']->count())
			<h3>1-ый тайм</h3>
			@foreach ($outcomes->get('1x2')['1h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / X: {{ $bookmaker['offers']->get(0)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('1x2')['2h']->count())
			<h3>2-ой тайм</h3>
			@foreach ($outcomes->get('1x2')['2h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / X: {{ $bookmaker['offers']->get(0)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif
	@endif

	{{-- 1 или 2 --}}
	@if ($outcomes->get('12')['ord']->count() || $outcomes->get('12')['1h']->count() || $outcomes->get('12')['2h']->count())
		<h2>1 или 2</h2>
		@if ($outcomes->get('12')['ord']->count())
			<h3>Осн. время</h3>
			@foreach ($outcomes->get('12')['ord'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('12')['1h']->count())
			<h3>1-ый тайм</h3>
			@foreach ($outcomes->get('12')['1h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('12')['2h']->count())
			<h3>2-ой тайм</h3>
			@foreach ($outcomes->get('12')['2h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1: {{ $bookmaker['offers']->get(1)->odds }} / 2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif
	@endif

	{{-- Двойной шанс --}}
	@if ($outcomes->get('dc')['ord']->count() || $outcomes->get('dc')['1h']->count() || $outcomes->get('dc')['2h']->count())
		<h2>Двойной шанс</h2>

		@if ($outcomes->get('dc')['ord']->count())
			<h3>Осн. время</h3>
			@foreach ($outcomes->get('dc')['ord'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1X: {{ $bookmaker['offers']->get(1)->odds }} / 12: {{ $bookmaker['offers']->get(0)->odds }} / X2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('dc')['1h']->count())
			<h3>1-ый тайм</h3>
			@foreach ($outcomes->get('dc')['1h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1X: {{ $bookmaker['offers']->get(1)->odds }} / 12: {{ $bookmaker['offers']->get(0)->odds }} / X2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('dc')['2h']->count())
			<h3>2-ой тайм</h3>
			@foreach ($outcomes->get('dc')['2h'] as $bookmaker)
				{{ $bookmaker['name'] }} / 1X: {{ $bookmaker['offers']->get(1)->odds }} / 12: {{ $bookmaker['offers']->get(0)->odds }} / X2: {{ $bookmaker['offers']->get(2)->odds }}<br>
			@endforeach
		@endif
	@endif

	{{-- Чет/Нечет --}}
	@if ($outcomes->get('oe')['ord']->count() || $outcomes->get('oe')['1h']->count() || $outcomes->get('oe')['2h']->count())
		<h2>Чет/Нечет</h2>

		@if ($outcomes->get('oe')['ord']->count())
			<h3>Осн. время</h3>
			@foreach ($outcomes->get('oe')['ord'] as $bookmaker)
				{{ $bookmaker['name'] }} / Нечет: {{ $bookmaker['offers']->get('odd')->odds }} / Чет: {{ $bookmaker['offers']->get('even')->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('oe')['1h']->count())
			<h3>1-ый тайм</h3>
			@foreach ($outcomes->get('oe')['1h'] as $bookmaker)
				{{ $bookmaker['name'] }} / Нечет: {{ $bookmaker['offers']->get('odd')->odds }} / Чет: {{ $bookmaker['offers']->get('even')->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('oe')['2h']->count())
			<h3>2-ой тайм</h3>
			@foreach ($outcomes->get('oe')['2h'] as $bookmaker)
				{{ $bookmaker['name'] }} / Нечет: {{ $bookmaker['offers']->get('odd')->odds }} / Чет: {{ $bookmaker['offers']->get('even')->odds }}<br>
			@endforeach
		@endif
	@endif

	{{-- Обе забьют? --}}
	@if ($outcomes->get('bts')['ord']->count() || $outcomes->get('bts')['1h']->count() || $outcomes->get('bts')['2h']->count())
		<h2>Обе забьют?</h2>

		@if ($outcomes->get('bts')['ord']->count())
			<h3>Осн. время</h3>
			@foreach ($outcomes->get('bts')['ord'] as $bookmaker)
				{{ $bookmaker['name'] }} / Да: {{ $bookmaker['offers']->get('yes')->odds }} / Нет: {{ $bookmaker['offers']->get('no')->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('bts')['1h']->count())
			<h3>1-ый тайм</h3>
			@foreach ($outcomes->get('bts')['1h'] as $bookmaker)
				{{ $bookmaker['name'] }} / Да: {{ $bookmaker['offers']->get('yes')->odds }} / Нет: {{ $bookmaker['offers']->get('no')->odds }}<br>
			@endforeach
		@endif

		@if ($outcomes->get('bts')['2h']->count())
			<h3>2-ой тайм</h3>
			@foreach ($outcomes->get('bts')['2h'] as $bookmaker)
				{{ $bookmaker['name'] }} / Да: {{ $bookmaker['offers']->get('yes')->odds }} / Нет: {{ $bookmaker['offers']->get('no')->odds }}<br>
			@endforeach
		@endif
	@endif

@endsection

