@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannerformat.index')
			])

			@can('update', $bannerformat)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannerformat.edit', [
						'bannerformat' => $bannerformat->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannerformat,
				'model'		=> \App\Bannerformat::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'width',
						'height',
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
					'picture',
					'link',
					'bannercampaign',
					'bannerposts_count',
				],
				'values'	=> [
					'bannerformat_id' => $bannerformat->id
				],
			])
		@endslot
	@endcomponent
@endsection

