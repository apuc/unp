@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.legaldocument.index'),
		'dataset'   => $legaldocument,
		'model'     => \App\Legaldocument::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'announce',
				'position',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection