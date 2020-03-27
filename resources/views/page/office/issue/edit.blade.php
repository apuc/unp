@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.issue.show', $issue->id),
		'dataset'   => $issue,
		'model'     => \App\Issue::class,
		'groups'	=> [
			'properties' => [
				'posted_at',
				'user',
				'issuetype',
				'issuestatus',
				'author',
				'email',
				'message',
			],
		],
	])
@endsection
