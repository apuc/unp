@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.briefcomment.show', $briefcomment->id),
		'dataset'   => $briefcomment,
		'model'     => \App\Briefcomment::class,
		'groups'	=> [
			'properties' => [
				'brief',
				'user',
				'commentstatus',
				'posted_at',
				'message',
			],
		],
	])
@endsection
