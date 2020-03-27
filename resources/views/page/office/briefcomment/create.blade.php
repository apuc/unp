@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.briefcomment.index'),
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

