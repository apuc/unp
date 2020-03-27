@extends('layout.office.app')

@php
    $title = trans('page.office.site.index')
@endphp

@section('content')
	<div class="card-deck dashboart">
		{{--
		<div id="notification-unclosedorders" class="card dashboart__item">
			<div class="card-body d-flex justify-content-between align-items-center">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				<div class="dashboart__title"><b class="notification-badge">0</b> <span>Незакрытых заказов</span></div>
			</div>
			<div class="card-footer">
				<a href="{{ route('office.order.index') }}" class="d-flex">
					<span>Узнать больше</span>
					<i class="fa fa-chevron-right ml-auto" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		<div id="notification-newcallbacks" class="card dashboart__item">
			<div class="card-body d-flex justify-content-between align-items-center">
				<i class="fa fa-volume-control-phone" aria-hidden="true"></i>
				<div class="dashboart__title"><b class="notification-badge">0</b> <span>Новых звонков</span></div>
			</div>
			<div class="card-footer">
				<a href="{{ route('office.callback.index') }}" class="d-flex">
					<span>Узнать больше</span>
					<i class="fa fa-chevron-right ml-auto" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		<div id="notification-newshopreviews" class="card dashboart__item">
			<div class="card-body d-flex justify-content-between align-items-center">
				<i class="fa fa-comments" aria-hidden="true"></i>
				<div class="dashboart__title"><b class="notification-badge">0</b> <span>Новых отзывов</span></div>
			</div>
			<div class="card-footer">
				<a href="{{ route('office.shopreview.index') }}" class="d-flex">
					<span>Узнать больше</span>
					<i class="fa fa-chevron-right ml-auto" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>

	<script>
		$('body').bind('ss.notification.unclosedorders.loaded', function (e, counter) {
			if (counter.value > 0)
				$('#notification-unclosedorders').addClass('active');
			else
				$('#notification-unclosedorders').removeClass('active');

			$('#notification-unclosedorders .dashboart__title span').text(counter.parameters.title);
		});

		$('body').bind('ss.notification.newcallbacks.loaded', function (e, counter) {
			if (counter.value > 0)
				$('#notification-newcallbacks').addClass('active');
			else
				$('#notification-newcallbacks').removeClass('active');

			$('#notification-newcallbacks .dashboart__title span').text(counter.parameters.title);
		});

		$('body').bind('ss.notification.newshopreviews.loaded', function (e, counter) {
			if (counter.value > 0)
				$('#notification-newshopreviews').addClass('active');
			else
				$('#notification-newshopreviews').removeClass('active');

			$('#notification-newshopreviews .dashboart__title span').text(counter.parameters.title);
		});
	</script>
	--}}
@endsection
