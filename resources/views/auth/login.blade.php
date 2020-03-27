@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="{{ route('login') }}">
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>
				<div class="col-md-7 col-xl-8">
					<input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-Mail">

					@if ($errors->has('email'))
						<div class="invalid-feedback">{{ $errors->first('email') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label">Пароль</label>
				<div class="col-md-7 col-xl-8">
					<input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Пароль">

					@if ($errors->has('password'))
						<div class="invalid-feedback">{{ $errors->first('password') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2">&nbsp;</div>
				<div class="col-md-7 col-xl-8">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" name="remember" id="remember" type="checkbox">
						<label class="custom-control-label" for="remember">Запомнить меня на этом компьютере</label>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
					<button type="submit" class="btn btn-primary">Войти</button>
				</div>
			</div>
		</form>

		<div class="row">
			<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
				<div><a href="{{ url('/password/reset') }}">Забыли логин или пароль?</a></div>
				<div><a href="{{ url('/register') }}">Регистрация</a></div>
			</div>
		</div>
	</div>
@endsection