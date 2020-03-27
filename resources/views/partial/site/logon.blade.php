@if (Auth::guest())
	<div class="modal fade" id="win-logon" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog win-registration" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<h4>Вход в личный кабинет</h4>
					<p class="text-big">Через социальные сети</p>
					<div class="modal-social">
						<a href="{{ route('login.vkontakte') }}" rel="nofollow"><i class="fa fa-vk" aria-hidden="true"></i></a>
						<a href="{{ route('login.facebook') }}" rel="nofollow"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="{{ route('login.google') }}" rel="nofollow"><i class="fa fa-google" aria-hidden="true"></i></a>
						{{--
						<a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						--}}
					</div>
					<p class="text-big">С паролем</p>

					<form id="t-login" method="post" action="{{ route('login') }}">
						{{ csrf_field() }}
						<div class="form-item">
							<label>Электронная почта</label>
							<input type="text" name="email" class="form-control form-control-lg m-input" placeholder="Электронная почта" data-value="Электронная почта">
						</div>
						<div class="form-item">
							<label>Пароль</label>
							<input type="password" name="password" class="form-control form-control-lg m-input" placeholder="Пароль" data-value="Пароль">
						</div>

						<div class="custom-checkbox mt-2">
							<input class="custom-control-input" name="remember" id="t-remember" type="checkbox">
							<label class="custom-control-label" for="t-remember">Запомнить меня на этом компьютере</label>
						</div>

						<button
							type="submit"
							class="btn btn-primary btn-lg mt-4"
						>Войти</button>
					</form>

					<div class="mt-3"><a href="{{ url('/password/reset') }}">Я не помню пароль</a></div>
					<div class="text-link mt-2"><a href="{{ url('/register') }}">Регистрация</a></div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.form-item').find('input,textarea').bind('focus', function() {
				$(this).attr('placeholder', '');
				$(this).parent().find('label').addClass('active');
			});

			$('.form-item').find('input').bind('blur', function() {
				$(this).attr(
					'placeholder',
					$(this).attr('data-value')
				);
				$(this).parent().find('label').removeClass('active');
			});
		});
	</script>
@else
	<div class="modal fade" id="win-logon" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog win-registration" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
					<h4>Добавить вход</h4>
					<div class="modal-social">
						<a href="{{ route('login.vkontakte') }}"><i class="fa fa-vk" aria-hidden="true"></i></a>
						<a href="{{ route('login.facebook') }}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						<a href="{{ route('login.google') }}" rel="nofollow"><i class="fa fa-google" aria-hidden="true"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif