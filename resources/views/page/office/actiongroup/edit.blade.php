@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.actiongroup.show', $actiongroup->id),
		'dataset'   => $actiongroup,
		'model'     => \App\Actiongroup::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection
