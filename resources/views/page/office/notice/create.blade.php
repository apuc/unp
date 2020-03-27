@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.notice.index'),
		'dataset'   => $notice,
		'model'     => \App\Notice::class,
		'groups'	=> [
			'properties' => [
				'posted_at',
				'event',
				'noticetype',
				'noticestatus',
				'user',
				'message',
			],
		],
	])
@endsection

