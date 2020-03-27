@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap">
		<div class="alert alert-danger">
			<strong>@lang('message.form.error')</strong> @lang('message.form.validation-failed')
		</div>

		<div class="row">
			<div class="col">
				@if ($social == 'vk')
					<a class="btn btn-primary btn-lg" href="{{ route('login.vkontakte') }}">Повторить попытку</a>
				@elseif ($social == 'facebook')
					<a class="btn btn-primary btn-lg" href="{{ route('login.facebook') }}">Повторить попытку</a>
				@endif
			</div>
		</div>
	</div>
@endsection
