@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.legaldocument.show', $legaldocument->id),
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
