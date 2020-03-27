@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.postcomment.index'),
		'dataset'   => $postcomment,
		'model'     => \App\Postcomment::class,
		'groups'	=> [
			'properties' => [
				'post',
				'user',
				'commentstatus',
				'posted_at',
				'message',
			],
		],
	])
@endsection

