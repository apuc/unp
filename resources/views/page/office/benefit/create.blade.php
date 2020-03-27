@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.benefit.index'),
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

