@extends('layout.site.grid.double')

<!-- Main Content -->
@section('content')
	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="{{ url('/password/email') }}">
			{{ csrf_field() }}

			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>

				<div class="col-md-7 col-xl-8">
					<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

					@if ($errors->has('email'))
						<div class="invalid-feedback">{{ $errors->first('email') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button type="submit" class="btn btn-primary">
						Отправить ссылку на сброс пароля
					</button>
				</div>
			</div>
		</form>
	</div>
@endsection
