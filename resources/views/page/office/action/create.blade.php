@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.action.index'),
		'dataset'   => $action,
		'model'     => \App\Action::class,
		'groups'	=> [
			'properties' => [
				'actiongroup',
				'name',
				'slug',
				'description',
			],
		],
	])
@endsection

