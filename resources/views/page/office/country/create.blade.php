@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.country.index'),
		'dataset'   => $country,
		'model'     => \App\Country::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'flag',
				'is_enabled',
			],
			'external' => [
				'external_id',
				'external_name',
			],
		],
	])
@endsection

