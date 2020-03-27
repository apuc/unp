@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.briefpicture.show', $briefpicture->id),
		'dataset'   => $briefpicture,
		'model'     => \App\Briefpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'brief',
				'picture',
			],
		],
	])
@endsection
