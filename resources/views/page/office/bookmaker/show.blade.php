@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bookmaker.index')
			])

			@can('update', $bookmaker)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bookmaker.edit', [
						'bookmaker' => $bookmaker->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bookmaker,
				'model'		=> \App\Bookmaker::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'logo',
						'cover',
						'bonus',
						'announce',
						'description',
						'site',
						'phone',
						'email',
						'address',
						'external_id',
						'position',
						'is_enabled',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'forecasts_count',
						'offers_count',
						'deals_count',
						'bookmakertexts_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Offer::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Deal::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Bookmakertext::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'match',
					'started_at',
					'user',
					'forecaststatus',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $offers,
				'model'		=> \App\Offer::class,
				'fields'	=> [
					'outcome',
					'odds_current',
					'odds_old',
					'coupon',
					'has_offers',
					'external_id',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $deals,
				'model'		=> \App\Deal::class,
				'fields'	=> [
					'name',
					'dealtype',
					'cover',
					'started_at',
					'finished_at',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bookmakertexts,
				'model'		=> \App\Bookmakertext::class,
				'fields'	=> [
					'name',
					'slug',
					'picture',
					'is_enabled',
					'bookmakerpictures_count',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			])
		@endslot
	@endcomponent
@endsection

