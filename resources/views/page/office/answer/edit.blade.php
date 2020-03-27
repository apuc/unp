@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.answer.show', $answer->id),
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
