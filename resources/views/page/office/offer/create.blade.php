@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.offer.index'),
		'dataset'   => $offer,
		'model'     => \App\Offer::class,
		'groups'	=> [
			'properties' => [
				'bookmaker',
				'outcome',
				'odds_current',
				'odds_old',
				'coupon',
				'has_offers',
				'external_id',
			],
		],
	])
@endsection

