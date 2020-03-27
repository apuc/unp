@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.outcomescope.index'),
		'dataset'   => $outcomescope,
		'model'     => \App\Outcomescope::class,
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
		],
	])
@endsection

