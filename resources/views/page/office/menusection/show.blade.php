@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.menusection.index')
			])

			@can('update', $menusection)
				@include('control.office.toolbar.edit', [
					'url' => route('office.menusection.edit', [
						'menusection' => $menusection->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $menusection,
				'model'		=> \App\Menusection::class,
				'groups'	=> [
					'properties' => [
						'name',
						'url',
						'is_enabled',
						'position',
						'menuitems_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Menuitem::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $menuitems,
				'model'		=> \App\Menuitem::class,
				'fields'	=> [
					'name',
					'url',
					'is_enabled',
					'position',
				],
				'values'	=> [
					'menusection_id' => $menusection->id
				],
			])
		@endslot

	@endcomponent
@endsection

