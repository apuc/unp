@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.noticetype.index'),
		'dataset'   => $noticetype,
		'model'     => \App\Noticetype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

