@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.noticeban.index'),
		'dataset'   => $noticeban,
		'model'     => \App\Noticeban::class,
		'groups'	=> [
			'properties' => [
				'noticetype',
				'action',
				'user',
			],
		],
	])
@endsection

