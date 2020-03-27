@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.outcome.show', $outcome->id),
		'dataset'   => $outcome,
		'model'     => \App\Outcome::class,
		'groups'	=> [
			'properties' => [
				'match',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'team',
			],
			'external' => [
				'external_id',
			],
		],
	])
@endsection
