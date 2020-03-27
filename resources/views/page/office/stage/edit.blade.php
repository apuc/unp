@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.stage.show', $stage->id),
		'dataset'   => $stage,
		'model'     => \App\Stage::class,
		'groups'	=> [
			'properties' => [
				'name',
				'season',
				'gender',
				'country',
				'external_id',
			],
		],
	])
@endsection
