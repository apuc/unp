@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.customtype.index')
			])

			@can('update', $customtype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.customtype.edit', [
						'customtype' => $customtype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $customtype,
				'model'		=> \App\Customtype::class,
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
					'customgroup',
					'value_string',
					'value_integer',
					'value_float',
					'value_text',
					'value_boolean',
				],
				'values'	=> [
					'customtype_id' => $customtype->id
				],
			])
		@endslot
	@endcomponent
@endsection

