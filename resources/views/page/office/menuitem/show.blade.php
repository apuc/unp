@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.menuitem.index')
			])

			@can('update', $menuitem)
				@include('control.office.toolbar.edit', [
					'url' => route('office.menuitem.edit', [
						'menuitem' => $menuitem->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $menuitem,
				'model'		=> \App\Menuitem::class,
				'groups'	=> [
					'properties' => [
						'name',
						'url',
						'menusection',
						'is_enabled',
						'position',
					],
				],
			])
		@endslot
	@endcomponent
@endsection

