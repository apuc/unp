@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.participant.index'),
		'dataset'   => $participant,
		'model'     => \App\Participant::class,
		'groups'	=> [
			'properties' => [
				'match',
				'team',
				'score',
				'position',
				'external_id',
			],
		],
	])
@endsection

