@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.offer.show', $offer->id),
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
