@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.notice.show', $notice->id),
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
