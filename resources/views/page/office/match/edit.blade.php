@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.match.show', $match->id),
		'dataset'   => $match,
		'model'     => \App\Match::class,
		'groups'	=> [
			'properties' => [
				'name',
				'stage',
				'started_at',

				'bookmaker1',
				'odds1_current',
				'odds1_old',

				'bookmakerx',
				'oddsx_current',
				'oddsx_old',

				'bookmaker2',
				'odds2_current',
				'odds2_old',

				'external_id',

				'matchstatus',
			],
		],
	])
@endsection
