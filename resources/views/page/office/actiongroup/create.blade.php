@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.actiongroup.index'),
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

