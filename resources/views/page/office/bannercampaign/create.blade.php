@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannercampaign.index'),
		'dataset'   => $bannercampaign,
		'model'     => \App\Bannercampaign::class,
		'groups'	=> [
			'properties' => [
				'name',
			],
		],
	])
@endsection

