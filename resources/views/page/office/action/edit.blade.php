@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.action.show', $action->id),
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
