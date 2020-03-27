@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.participant.show', $participant->id),
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
