@extends('layout.site.grid.double')

@section('content')

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="{{ url('/register') }}">
			<input type="hidden" name="id" value="{{ old('socialaccount_id') }}">
			<input type="hidden" name="social" value="{{ old('social') }}">
			<input type="hidden" name="name" value="{{ old('name') }}">
			<input type="hidden" name="avatar" value="{{ old('avatar') }}">

			{{ csrf_field() }}

			<div class="form-group row">
				<label for="name" class="col-md-3 col-xl-2 col-form-label">@lang('field.site.login')</label>

				<div class="col-md-7 col-xl-8">
					<input id="login" type="text" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login" value="{{ old('login') }}" required autofocus>

					@if ($errors->has('login'))
						<div class="invalid-feedback">
							{{ $errors->first('login') }}
						</div>
					@endif
				</div>
			</div>

			@if (is_null(old('email')))
				<div class="form-group row">
					<label for="email" class="col-md-3 col-xl-2 col-form-label">@lang('field.site.email')</label>

					<div class="col-md-7 col-xl-8">
						<input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

						@if ($errors->has('email'))
							<div class="invalid-feedback">
								{{ $errors->first('email') }}
							</div>
						@endif
					</div>
				</div>
			@else
				<input type="hidden" name="email" value="{{ old('email') }}">
			@endif

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button type="submit" class="btn btn-primary">Войти</button>
				</div>
			</div>
		</form>
	</div>
@endsection
