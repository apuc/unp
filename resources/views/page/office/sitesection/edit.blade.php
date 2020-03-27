@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.sitesection.show', $sitesection->id),
		'dataset'   => $sitesection,
		'model'     => \App\Sitesection::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection
