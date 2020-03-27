@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannerformat.index'),
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

