@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.tag.index'),
		'dataset'   => $tag,
		'model'     => \App\Tag::class,
		'groups'	=> [
			'properties' => [
				'name',
			],
		],
	])
@endsection

