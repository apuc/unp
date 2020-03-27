@extends('layout.site.grid.double')

@section('content')
	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="{{ url('/password/reset') }}">
			{{ csrf_field() }}

			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>

				<div class="col-md-7 col-xl-8">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>

					@if ($errors->has('email'))
						<div class="invalid-feedback">{{ $errors->first('email') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label">Пароль</label>

				<div class="col-md-7 col-xl-8">
					<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

					@if ($errors->has('password'))
						<div class="invalid-feedback">{{ $errors->first('password') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="password-confirm" class="col-md-3 col-xl-2 col-form-label">Повтор пароля</label>
				<div class="col-md-7 col-xl-8">
					<input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

					@if ($errors->has('password_confirmation'))
						<div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
					<button type="submit" class="btn btn-primary">Сброс пароля</button>
				</div>
			</div>
		</form>
	</div>
@endsection
