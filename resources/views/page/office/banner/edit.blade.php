@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.banner.show', $banner->id),
		'dataset'   => $banner,
		'model'     => \App\Banner::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bannerformat',
				'bannercampaign',
				'picture',
				'link',
				'html',
				'alt',
			],
		],
	])
@endsection
