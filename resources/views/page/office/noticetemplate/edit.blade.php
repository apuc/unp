@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.noticetemplate.show', $noticetemplate->id),
		'dataset'   => $noticetemplate,
		'model'     => \App\Noticetemplate::class,
		'groups'	=> [
			'properties' => [
				'action',
				'noticetype',
				'role',
				'message',
			],
		],
	])
@endsection
