@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.postpicture.show', $postpicture->id),
		'dataset'   => $postpicture,
		'model'     => \App\Postpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'post',
				'picture',
			],
		],
	])
@endsection
