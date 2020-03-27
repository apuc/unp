@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.brieftag.show', $brieftag->id),
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
