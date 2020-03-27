@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannerpost.index'),
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

