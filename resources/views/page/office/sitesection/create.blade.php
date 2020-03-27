@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.sitesection.index'),
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

