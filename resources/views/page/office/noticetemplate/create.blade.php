@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.noticetemplate.index'),
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

