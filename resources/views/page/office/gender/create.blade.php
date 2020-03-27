@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.gender.index'),
		'dataset'   => $gender,
		'model'     => \App\Gender::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

