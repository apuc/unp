@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannerpost.index')
			])

			@can('update', $bannerpost)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannerpost.edit', [
						'bannerpost' => $bannerpost->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannerpost,
				'model'		=> \App\Bannerpost::class,
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
		@endslot
	@endcomponent
@endsection

