@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap" id="setting-notifications">
		<h2 class="title">НАСТРОЙКА УВЕДОМЛЕНИЙ</h2>
		{{--<p>Текст вводный, как принято считать, концентрирует конкурент. В общем, медиапланирование порождает коллективный нишевый проект, полагаясь на инсайдерскую информацию.</p>--}}

		<div class="row">
			<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
				<div class="notification-setting">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="1">
						<label class="custom-control-label" for="1">Получать новости</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="2" checked>
						<label class="custom-control-label" for="2">Уведомлять на&nbsp;E-mail о&nbsp;результатах Вашего прогноза <span class="red">*</span></label>
					</div>
				</div>
			</div>
		</div>
		<div class="btn-account-row">
			<a href="#" class="btn btn-primary pl-4 pr-4">Сохранить настройки</a>
		</div>
	</div>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection