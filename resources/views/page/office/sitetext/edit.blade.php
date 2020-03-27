@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.sitetext.show', $sitetext->id),
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
