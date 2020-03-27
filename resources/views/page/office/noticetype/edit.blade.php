@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.noticetype.show', $noticetype->id),
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
