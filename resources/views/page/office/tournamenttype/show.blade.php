@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.tournamenttype.index')
			])

			@can('update', $tournamenttype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.tournamenttype.edit', [
						'tournamenttype' => $tournamenttype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $tournamenttype,
				'model'		=> \App\Tournamenttype::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Tournament::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $tournaments,
				'model'		=> \App\Tournament::class,
				'fields'	=> [
					'sport',
					'gender',
					'name',
					'logo',
					'external_id',
					'position',
					'is_top',
					'seasons_count',
					'tournamentposts_count',
					'tournamentbriefs_count',
				],
				'values'	=> [
					'tournamenttype_id' => $tournamenttype->id
				],
			])
		@endslot
	@endcomponent
@endsection

