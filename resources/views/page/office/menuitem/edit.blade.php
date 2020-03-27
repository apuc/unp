@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.menuitem.show', $menuitem->id),
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
