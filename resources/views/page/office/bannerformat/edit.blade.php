@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannerformat.show', $bannerformat->id),
		'dataset'   => $bannerformat,
		'model'     => \App\Bannerformat::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'width',
				'height',
			],
		],
	])
@endsection
