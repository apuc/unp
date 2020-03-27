$(document).ready(function() {

	$('#win-nav .win-nav').bind('ssScrollbarInit', function (e, bar) {
		bar.block.css({
			'height': $('#win-nav').innerHeight() + 'px'
		});
	});

	$('#win-nav .win-nav').bind('ssScrollbarStop', function (e, bar) {
		bar.block.css({
			'height': ''
		});
	});

	var bar = ssScrollbar({
		block:	$('#win-nav .win-nav'),
		inner:	$('#win-nav .modal-body')
	});

	win // триггеры навигации

		// триггер "открытие меню"
		.trigger('nav', 'ssWinInsteadOpen', function (e, w) {

			// событие "начало закрытия меню"
			$('#win-nav').bind('hide.bs.modal', function () {
				// уничтожаем событие "начало закрытия меню"
				$('#win-nav').unbind('hide.bs.modal');

				// ставим флаг, что скрипт окон занят
				w.addClass('ss-win-busy');
			});

			// событие "конец закрытия меню"
			$('#win-nav').bind('hidden.bs.modal', function () {

				// уничтожаем событие "конец закрытия меню"
				$('#win-nav').unbind('hidden.bs.modal');

				// создаем чекалку
				var id = setInterval(function () {
					// открыто ли меню?
					if (!$('body').hasClass('modal-open')) {
						// если нет

						// удаляем флаг занятости
						w.removeClass('ss-win-busy');

						// удаляем флаг открытого окна
						$('body').removeClass('modal-nav');

						// прерываем чекалку
						clearInterval(id);
					}
				}, 1);

				// запускаем алгоритм закрытия меню
				win.close('nav');
			});

			$('#win-nav').bind('shown.bs.modal', function () {
				$('#win-nav').unbind('shown.bs.modal');
				bar.reboot();
			})

			// создаем флаг открытого окна меню
			$('body').addClass('modal-nav');

			// запускаем анимацию открытия
			$('#win-nav').modal('show');
		})

		// триггер "закрытие окна"
		.trigger('nav', 'ssWinInsteadClose', function () {
			// запускаем анимацию закрытия (запуск этой анимации
			// запустит два триггера hide.bs.modal и hidden.bs.modal)
			$('#win-nav').modal('hide');
		})

		// триггер "ресайз окна браузера"
		.trigger('nav', 'ssWinResize', function () {
			if (
				// если ширина окна браузера  более 990
					$(window).width() > 990
				// и меню открыто
				&&	win.isOpened('nav')
			)
				// запускаем алгоритм закрытия меню
				win.close('nav');
		})
	;

	$(window).resize(function () {
		bar.reboot();
	});
});