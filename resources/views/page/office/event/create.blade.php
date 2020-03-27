@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.event.index'),
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

