@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.menusection.index'),
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

