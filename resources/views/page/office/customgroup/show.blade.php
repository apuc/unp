@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.customgroup.index')
			])

			@can('update', $customgroup)
				@include('control.office.toolbar.edit', [
					'url' => route('office.customgroup.edit', [
						'customgroup' => $customgroup->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $customgroup,
				'model'		=> \App\Customgroup::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'statistics' => [
						'customparams_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Customparam::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $customparams,
				'model'		=> \App\Customparam::class,
				'fields'	=> [
					'name',
					'slug',
					'customtype',
					'value_string',
					'value_integer',
					'value_float',
					'value_text',
					'value_boolean',
				],
				'values'	=> [
					'customgroup_id' => $customgroup->id
				],
			])
		@endslot
	@endcomponent
@endsection

