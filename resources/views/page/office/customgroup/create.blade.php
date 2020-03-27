@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.customgroup.index'),
		'dataset'   => $customgroup,
		'model'     => \App\Customgroup::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

