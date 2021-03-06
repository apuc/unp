@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.helpsection.index'),
		'dataset'   => $helpsection,
		'model'     => \App\Helpsection::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'icon',
				'announce',
				'text_header',
				'text_footer',
				'is_enabled',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection

