@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannerpost.show', $bannerpost->id),
		'dataset'   => $bannerpost,
		'model'     => \App\Bannerpost::class,
		'groups'	=> [
			'properties' => [
				'banner',
				'sitesection',
				'bannerplace',
				'margin',
				'started_at',
				'finished_at',
				'view_limit',
				'view_amount',
				'click_limit',
				'click_amount',
				'is_enabled',
				'is_debug',
			],
		],
	])
@endsection
