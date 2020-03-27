@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.issue.index'),
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

