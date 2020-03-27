@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap" id="social-authorization">
		<h2 class="title">НАСТРОЙКА АВТОРИЗАЦИИ ЧЕРЕЗ СОЦСЕТИ</h2>
		{{--<p>Текст вводный, как принято считать, концентрирует конкурент. В общем, медиапланирование порождает коллективный нишевый проект, полагаясь на инсайдерскую информацию.</p>--}}

		<div class="btn-account-row row-top">
			<a href="#" class="btn btn-primary pl-4 pr-4" data-toggle="modal" data-target="#win-logon"><i class="fa fa-plus" aria-hidden="true"></i> Добавить вход</a>
		</div>

		@if ($errors->count())
			<div class="alert alert-danger">
				<strong>@lang('message.form.error')</strong> @lang('message.form.validation-failed')
				<ul class="mt-1 mb-0">
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if ($usersocials->count())
			@foreach ($usersocials as $usersocial)
				<div class="card settings-card">
					<div class="card-body">
						{{--<a href="#"><img src="storage/profile/avatar.gif" alt=""></a>--}}
						<div class="social-name"><a href="{{ $usersocial->social->site }}">{{ $usersocial->social->name }}</div>
						<div class="social-del ml-auto">
							<a onclick="
								socialDestroy(
									'{{ route('account.social.destroy', ['social_id' => $usersocial->id]) }}',
									'{{ csrf_token() }}',
									'{{ trans('message.site.social.destroy') }}'
								)
							" href="javascript: void(0);"><i class="fa fa-times" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>

	<script>
		/**
		 * функция удаление соцсети
		 *
		 * @param string route
		 * @param string csrf
		 * @param string message
		 * @param boolean step
		 */

		function socialDestroy(route, csrf, message, step)
		{
			if (undefined === step) {
				if (confirm(message))
					socialDestroy(route, csrf, message, true);
			}

			else if (true === step)
				$.post(
					route,
					{
						'_token':  csrf,
						'_method': 'DELETE'
					},
					function(answer) {
						// перезагружаем страницу
						location.reload(true);
					}
				);
		}
	</script>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection