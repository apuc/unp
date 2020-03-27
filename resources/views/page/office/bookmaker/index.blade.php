@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Bookmaker::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.bookmaker.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.bookmaker.filter-button')
		</div>
		@include('page.office.bookmaker.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $bookmakers,
			'model'		=> \App\Bookmaker::class,
			'fields'	=> [
				'name',
				'slug',
				'logo',
				'site',
				'bonus',
				'external_id',
				'position',
				'is_enabled',
				'forecasts_count',
				'offers_count',
				'deals_count',
				'bookmakertexts_count',
			],
		])
	</div>

	@include('partial.office.shell.modal-editor', [
		'action' => 'create'
    ])

	@include('partial.office.shell.modal-editor', [
    	'action' => 'edit'
	])
@endsection
