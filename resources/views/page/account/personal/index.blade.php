@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap" id="personal-data">
		<h2 class="title">Изменение личных данных</h2>
		{{--<p>Текст вводный, как принято считать, концентрирует конкурент. В общем, медиапланирование порождает коллективный нишевый проект, полагаясь на инсайдерскую информацию.</p>--}}
		<form action="{{ route('account.personal.index') }}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="type" value="contacts">
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="name" class="col-md-3 col-form-label">Имя</label>
				<div class="col-md-9">
					<input name="name" type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ?? Auth::user()->name }}">
					@if ($errors->has('name'))
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="login" class="col-md-3 col-form-label">Логин <span class="red">*</span></label>
				<div class="col-md-9">
					<input name="login" type="text" id="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" value="{{ old('login') ?? Auth::user()->login }}">
					@if ($errors->has('login'))
						<div class="invalid-feedback">{{ $errors->first('login') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="email" class="col-md-3 col-form-label">E-mail <span class="red">*</span></label>
				<div class="col-md-9">
					<input name="email" type="email" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') ?? Auth::user()->email }}">
					@if ($errors->has('email'))
						<div class="invalid-feedback">{{ $errors->first('email') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label for="phone" class="col-md-3 col-form-label">Телефон</label>
				<div class="col-md-9">
					<input name="phone" type="phone" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') ?? Auth::user()->phone }}">
					@if ($errors->has('phone'))
						<div class="invalid-feedback">{{ $errors->first('phone') }}</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 col-form-label">Аватар</label>
				<div class="col-md-9 d-flex">
					<img src="{{ asset('preview/80/80/storage/users/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->nickname }}">
					<div class="avatar-act">
						<label for="avatar" class="btn btn-light">Загрузить изображение</label>
						<input type="file" hidden id="avatar" name="avatar">
						@if (!is_null(Auth::user()->avatar))
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="avatar_clean" id="del">
								<label class="custom-control-label" for="del">Удалить</label>
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="about" class="col-md-3 col-form-label">О себе</label>
				<div class="col-md-9">
					<textarea name="about" id="about" rows="5" class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}">{{ old('about') ?? Auth::user()->about }}</textarea>
					@if ($errors->has('about'))
						<div class="invalid-feedback">{{ $errors->first('about') }}</div>
					@endif
				</div>
			</div>
			<div class="btn-account-row">
				<button type="submit" class="btn btn-primary pl-4 pr-4">Сохранить данные</button>
			</div>
		</form>
	</div>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection