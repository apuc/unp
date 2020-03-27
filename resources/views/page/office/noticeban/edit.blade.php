@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.noticeban.show', $noticeban->id),
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
