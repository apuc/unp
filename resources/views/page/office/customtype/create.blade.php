@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.customtype.index'),
		'dataset'   => $customtype,
		'model'     => \App\Customtype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

