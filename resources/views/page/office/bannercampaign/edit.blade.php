@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannercampaign.show', $bannercampaign->id),
		'dataset'   => $bannercampaign,
		'model'     => \App\Bannercampaign::class,
		'groups'	=> [
			'properties' => [
				'name',
			],
		],
	])
@endsection
