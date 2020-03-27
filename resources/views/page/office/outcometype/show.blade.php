@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.outcometype.index')
			])

			@can('update', $outcometype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.outcometype.edit', [
						'outcometype' => $outcometype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $outcometype,
				'model'		=> \App\Outcometype::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'description',
						'position',
						'is_enabled',
					],
					'external' => [
						'external_id',
						'external_name',
						'external_description',
					],
					'statistics' => [
						'outcomes_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Outcome::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $outcomes,
				'model'		=> \App\Outcome::class,
				'fields'	=> [
					'match',
					'outcomescope',
					'outcomesubtype',
					'team',
					'external_id',
				],
				'values'	=> [
					'outcometype_id' => $outcometype->id
				],
			])
		@endslot
	@endcomponent
@endsection

