@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap" id="password-change">
		<h2 class="title">Изменение пароля</h2>
		{{--<p>Текст вводный, как принято считать, концентрирует конкурент.</p>--}}
		<form action="{{ route('account.password.index') }}" method="post">
			<input type="hidden" name="type" value="password">
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="old_password" class="col-md-3 col-form-label">Действующий пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="old_password" name="old_password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}">
					@if ($errors->has('old_password'))
						<div class="invalid-feedback">{{ $errors->first('old_password') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-md-3 col-form-label">Новый пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
					@if ($errors->has('password'))
						<div class="invalid-feedback">{{ $errors->first('password') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="password_confirmation" class="col-md-3 col-form-label">Повторите пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="password_confirmation" name="password_confirmation{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" class="form-control">
					@if ($errors->has('password_confirmation'))
						<div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
					@endif
				</div>
			</div>
			<div class="btn-account-row">
				<button type="submit" class="btn btn-primary pl-4 pr-4">Изменить пароль</button>
			</div>
		</form>
	</div>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection