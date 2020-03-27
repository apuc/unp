@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.sitetext.index'),
		'dataset'   => $sitetext,
		'model'     => \App\Sitetext::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'sitesection',
				'title',
				'picture',
				'announce',
				'content',
				'is_enabled',
				'position',
			],
		],
	])
@endsection

