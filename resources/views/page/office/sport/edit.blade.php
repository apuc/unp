@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.sport.show', $sport->id),
		'dataset'   => $sport,
		'model'     => \App\Sport::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'icon',
				'has_odds',
				'position',
				'external_id',
				'external_name',
				'is_enabled',
			],
		],
	])
@endsection
