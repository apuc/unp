@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.answer.index'),
		'dataset'   => $answer,
		'model'     => \App\Answer::class,
		'groups'	=> [
			'properties' => [
				'issue',
				'posted_at',
				'user',
				'message',
			],
		],
	])
@endsection

