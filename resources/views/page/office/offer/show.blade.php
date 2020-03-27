@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.offer.index')
			])

			@can('update', $offer)
				@include('control.office.toolbar.edit', [
					'url' => route('office.offer.edit', [
						'offer' => $offer->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $offer,
				'model'		=> \App\Offer::class,
				'groups'	=> [
					'properties' => [
						'bookmaker',
						'outcome',
						'odds_current',
						'odds_old',
						'coupon',
						'has_offers',
						'external_id',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

