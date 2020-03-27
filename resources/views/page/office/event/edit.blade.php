@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.event.show', $event->id),
		'dataset'   => $event,
		'model'     => \App\Event::class,
		'groups'	=> [
			'properties' => [
				'happened_at',
				'action',
				'user',
				'visitor',
				'params',
			],
		],
	])
@endsection
