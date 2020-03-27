@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.briefpicture.index'),
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

