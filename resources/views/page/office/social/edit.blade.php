@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.social.show', $social->id),
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
