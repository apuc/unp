@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.social.index'),
		'dataset'   => $social,
		'model'     => \App\Social::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'site',
				'community',
				'icon',
			],
		],
	])
@endsection

