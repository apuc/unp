@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannercampaign.index')
			])

			@can('update', $bannercampaign)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannercampaign.edit', [
						'bannercampaign' => $bannercampaign->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannercampaign,
				'model'		=> \App\Bannercampaign::class,
				'groups'	=> [
					'properties' => [
						'name',
					],
					'statistics' => [
						'banners_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Banner::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $banners,
				'model'		=> \App\Banner::class,
				'fields'	=> [
					'name',
					'bannerformat',
					'picture',
					'link',
					'bannerposts_count',
				],
				'values'	=> [
					'bannercampaign_id' => $bannercampaign->id
				],
			])
		@endslot
	@endcomponent
@endsection

