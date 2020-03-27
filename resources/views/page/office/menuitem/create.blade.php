@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.menuitem.index'),
		'dataset'   => $menuitem,
		'model'     => \App\Menuitem::class,
		'groups'	=> [
			'properties' => [
				'name',
				'url',
				'menusection',
				'is_enabled',
				'position',
			],
		],
	])
@endsection

