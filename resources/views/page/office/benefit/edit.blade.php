@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.benefit.show', $benefit->id),
		'dataset'   => $benefit,
		'model'     => \App\Benefit::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'icon',
				'announce',
				'url',
				'position',
			],
		],
	])
@endsection
