@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.menusection.show', $menusection->id),
		'dataset'   => $menusection,
		'model'     => \App\Menusection::class,
		'groups'	=> [
			'properties' => [
				'name',
				'url',
				'is_enabled',
				'position',
			],
		],
	])
@endsection
