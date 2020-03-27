@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.postpicture.index'),
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

