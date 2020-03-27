@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.brieftag.index'),
		'dataset'   => $brieftag,
		'model'     => \App\Brieftag::class,
		'groups'	=> [
			'properties' => [
				'brief',
				'tag',
			],
		],
	])
@endsection

