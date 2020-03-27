@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.outcome.index'),
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

