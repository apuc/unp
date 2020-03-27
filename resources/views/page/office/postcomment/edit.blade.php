@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.postcomment.show', $postcomment->id),
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
