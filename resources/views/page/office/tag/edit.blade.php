@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.tag.show', $tag->id),
		'dataset'   => $tag,
		'model'     => \App\Tag::class,
		'groups'	=> [
			'properties' => [
				'name',
			],
		],
	])
@endsection
