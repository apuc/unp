@extends('layout.site.grid.double')

@section('content')
	<div class="b-filter-top">
		<div class="b-filter-top__sport-nav">
			<ul class="b-filter-top__sport-main-list">
				<li class="b-filter-top__sport-main-item">
					<a href="javascript: void(0);" class="nav-link active">Сайт</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="{{ route('login.vkontakte') }}" class="nav-link">Вконтакте</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="{{ route('login.facebook') }}" class="nav-link">Facebook</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="{{ route('login.google') }}" class="nav-link">Google</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="card-wrap">
		<form id="reg" class="mt-3" role="form" method="POST" action="{{ url('/register') }}" onsubmit="return false;">
			{{ csrf_field() }}

			<div class="form-group row">
				<label for="login" class="col-md-3 col-xl-2 col-form-label">@lang('field.site.login')</label>
				<div class="col-md-7 col-xl-8">
					<input id="login" type="text" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" name="login" value="{{ old('login') }}" required autofocus>

					@if ($errors->has('login'))
						<div class="invalid-feedback">
							{{ $errors->first('login') }}
						</div>
					@endif
				</div>
			</div>

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

			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label">@lang('field.site.password')</label>
				<div class="col-md-7 col-xl-8">
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="" required>

					@if ($errors->has('password'))
						<div class="invalid-feedback">
							{{ $errors->first('password') }}
						</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="password_confirmation" class="col-md-3 col-xl-2 col-form-label">@lang('field.site.password_confirmation')</label>
				<div class="col-md-7 col-xl-8">
					<input id="password_confirmation" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" value="" required>

					@if ($errors->has('password_confirmation'))
						<div class="invalid-feedback">
							{{ $errors->first('password_confirmation') }}
						</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2">&nbsp;</div>
				<div class="col-md-7 col-xl-8">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input policy-check" id="reg-policy" type="checkbox">
						<label class="custom-control-label" for="reg-policy">Я согласен на обработку <a href="{{ url('/legal/privacy') }}">персональных данных</a></label>
						<div class="invalid-feedback policy-error">Вы не дали согласие на обработку персональных данных</div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button
						type="submit"
						class="btn btn-primary"
						onclick="
							ssCheckPolicy(event, $('#reg'), function () {
								$('#reg').attr('onsubmit', '');
								$('#reg').submit();
							});
						"
					>
						@lang('button.register')
					</button>
				</div>
			</div>
		</form>
	</div>
@endsection
