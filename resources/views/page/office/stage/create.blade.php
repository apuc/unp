@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.stage.index'),
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

