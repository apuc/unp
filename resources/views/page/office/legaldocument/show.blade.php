@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.legaldocument.index')
			])

			@can('update', $legaldocument)
				@include('control.office.toolbar.edit', [
					'url' => route('office.legaldocument.edit', [
						'legaldocument' => $legaldocument->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $legaldocument,
				'model'		=> \App\Legaldocument::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'announce',
						'position',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'legaleditions_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Legaledition::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $legaleditions,
				'model'		=> \App\Legaledition::class,
				'fields'	=> [
					'issued_at',
				],
				'values'  	=> [
					'legaldocument_id' => $legaldocument->id
				],
			])
		@endslot
	@endcomponent
@endsection

