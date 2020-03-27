@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.customgroup.show', $customgroup->id),
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
