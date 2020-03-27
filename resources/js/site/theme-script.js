(function($){
    "use strict";

	var scrollTo = function (value) {
		var width = $(window).innerWidth();
		var h = $(window).scrollTop();
		var max_h = $('header').height();
		if(width >= 992) {
			if( h > max_h) {
				$("body,html").animate({
					scrollTop:$("#" + value).offset().top-52
				},1000)
			} else {
				$("body,html").animate({
					scrollTop:$("#" + value).offset().top-100
				},1000)
			}
		}
	};

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {
        // scroll top
        $(document).on('click','.scroll-top',function(){
            $('body,html').animate({scrollTop:0},400);
            return false;
        })

   		$(".submenu-scroll a").click(function(){
			scrollTo($(this).data('value'));
 		})

         // view grid list product
        $(document).on('click','.product-view .view-as-grid',function(){
            $(this).closest('.product-view').find('.product-view__item').removeClass('selected');
            $(this).addClass('selected');
            $(this).closest('#view-cards-box').find('.cards-box').removeClass('cards_list').addClass('cards_tile');

            return false;
        })

        // view list list product
        $(document).on('click','.product-view .view-as-list',function(){
            $(this).closest('.product-view').find('.product-view__item').removeClass('selected');
            $(this).addClass('selected');
            $(this).closest('#view-cards-box').find('.cards-box').removeClass('cards_tile').addClass('cards_list');

            return false;
        })


        //
/*        $(document).on('click','.win-nav-link .icon-svg',function(){
        	if ($(this).hasClass('active')) {
        		$(this).closest('.win-nav-link').find('.icon-svg').removeClass('active');
        	}
        	else {
        		$(this).closest('.win-nav-link').find('.icon-svg').addClass('active');
        	}

            return false;
        })
            */


		$('.ss-filebrowse').find('input').bind('change', function () {
			var arr		= $(this).val().split('\\');
			var name	= (function () {
				var name	= arr[arr.length - 1];
				var sliced	= name.slice(0, 17);

				if (sliced.length < name.length)
					return sliced += '...';

				return sliced;
			})();

			$(this).parents('.ss-filebrowse').eq(0).find('label').text(name);
		});
    });

	$(window).bind('load', function () {
 		if (location.hash != "")
			scrollTo(location.hash.replace(/[#]+/g, ''));
	});

    /* ---------------------------------------------
     Scripts resize
     --------------------------------------------- */
    /*$(window).resize(function(){
        var width = parseInt($(window).width());
        if(width < 768){
            $('.header').removeClass('nav-ontop').removeClass('container');
        }
    });*/

    /* ---------------------------------------------
     Scripts scroll
     --------------------------------------------- */
    $(window).scroll(function() {
        /* Show hide scrolltop button */
        if( $(window).scrollTop() == 0 ) {
            $('.scroll-top').stop(false,true).fadeOut(600);
        }else{
            $('.scroll-top').stop(false,true).fadeIn(600);
        }

		/* Main menu on top */
		var h		= $(window).scrollTop();
		var max_h	= parseInt($('body').css('padding-top'));
		var header	= $('.header').innerHeight();
		if(h > max_h) {
			// fix top menu
			$('.header').addClass('nav-ontop').addClass('container');
			$('header').css('margin-top', header + 'px');
		} else {
			$('.header').removeClass('nav-ontop').removeClass('container');
			$('header').css('margin-top', '0');
		}
    });

    /* ---------------------------------------------
     Фильтры
     --------------------------------------------- */

	$(document).ready(function () {

		/**
		 * установка поций vue фильтра
		 *
		 */

		var setOptions = function (option, options, data) {
			// турниры
			if (option == 'tournaments') {
				options['tournaments'] = [];
				// есть ли в массиве турниры с is_top = 1
				if ((function () {
					for (var i in data)
						if (data[i].is_top == 1)
							return true;

					return false;
				})()) {
					// если есть, собираем 3 таких турнира
					for (var i in data)
						if (data[i].is_top == 1)
							if (options['tournaments'].length < 3)
								options['tournaments'].push(
									data[i].id
								);
				}
				// если нет, собираем три первых турнира
				else {
					for (var i in data)
						if (options['tournaments'].length < 3)
							options['tournaments'].push(
								data[i].id
							);
				}
			}

			// день
			if (option == 'day')
				options['day'] = data;

			// спорт
			if (option == 'sport')
				options['sport'] = data;
		}

		/**
		 * функция позволяет заблочить
		 * кнопки календаря, если дата выходит
		 * за пределы диапазона
		 */

		function b_calendar_nav()
		{
			// если есть блок календаря
			if ($('.b-filter-top__calendar').length > 0) {

				// скрываем навигацию
				$('.b-filter-top__calendar .b-calendar__nav-prev, .b-filter-top__calendar .b-calendar__nav-next').css('display', 'none');

				// листаем даты
				$('.b-filter-top__calendar .b-calendar-dates > div').each(function (i) {
					// если наткнулись на выбранную дату
					if ($(this).hasClass('active')) {
						// первый ли это пункт
						if (i > 0)
							// если нет, показываем навигацию "пред"
							$('.b-filter-top__calendar .b-calendar__nav-prev').css('display', '');

						// есть ли след дата после активной
						if ($('.b-filter-top__calendar .b-calendar-dates > div').eq(i + 1).length > 0)
							// если есть, показываем навигацию "след"
							$('.b-filter-top__calendar .b-calendar__nav-next').css('display', '');
					}
				});
			}
		}

		/**
		 * переход к предыдущему дню
		 *
		 */

		function b_calendar_prev()
		{
			$('.b-filter-top__calendar .b-calendar-dates > div').each(function (i) {
				if ($(this).hasClass('active'))
					$('.b-filter-top__calendar .b-calendar-dates > div').eq(i - 1).trigger('click');
			});
		}

		/**
		 * переход к следующему дню
		 *
		 */

		function b_calendar_next()
		{
			var day = null;

			$('.b-filter-top__calendar .b-calendar-dates > div').each(function (i) {
				if ($(this).hasClass('active'))
					day = $('.b-filter-top__calendar .b-calendar-dates > div').eq(i + 1);
			});

			if (null !== day)
				day.trigger('click');
		}

		/**
		 * событие "произошла отправка" данных для
		 * постранички (выбор даты)
		 *
		 */

		$('body').bind('ss.pn.submit', function (e, box) {
			// переназначаем день
			if (undefined !== box.attr('data-ss-pn-day-value')) {

				// хук позволяющий скорректировать лист параметров
				$('body').trigger('ss.pn.submit-day', [box]);

				// удаляем предыдущую дату
				$("*[data-ss-pn-parameter='day']").remove();
				$('.b-filter-top__calendar .b-calendar-dates').find('> div').removeClass('active');

				// если выбор не пустой
				if (box.attr('data-ss-pn-day-value') != '') {
					// помечаем пукт как активный
					box.addClass('active');

					// устанавливаем дату в информер
					$('#calendar-dates').find('span').eq(1).text(box.find('span').text());

					// создаем новую дату
					$('.b-filter-top__calendar').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="day"'
							+ ' data-ss-filter-input="day"'
							+ ' value="' + box.attr('data-ss-pn-day-value') + '"'
						+ '>'
					);

					if ($('*[data-ss-filter-url]').length > 0)
						ssFilter().event();
				}

				// показываем кнопки "след" и "пред"
				b_calendar_nav();
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (выбор спорта)
		 *
		 */

		$('body').bind('ss.pn.submit', function (e, box) {
			// переназначаем вид спорта
			if (undefined !== box.attr('data-ss-pn-sport-value')) {

				// хук позволяющий скорректировать лист параметров
				$('body').trigger('ss.pn.submit-sport', [box]);

				// удаляем предыдущий спорт
				$("*[data-ss-pn-parameter='sport']").remove();
				$('.b-filter-top__sport-main-list li a').removeClass('active');

				// если выбор не пустой
				if (box.attr('data-ss-pn-sport-value') != '') {
					// помечаем родительский пункт как активный (если есть)
					if (box.parents('.b-filter-top__sport-main-item').eq(0).length > 0)
						box.parents('.b-filter-top__sport-main-item').eq(0).find('> a').addClass('active');

					// помечаем пукт как активный
					box.addClass('active');

					// создаем новый спорт
					$('.b-filter-top__sport-main-list').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="sport"'
							+ ' value="' + box.attr('data-ss-pn-sport-value') + '"'
						+ '>'
					);
				}
				else
					// помечаем как активный пункт "все"
					$('.b-filter-top__sport-main-list .b-filter-top__sport-main-item').eq(0).find('a').addClass('active');
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (вид)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// переназначаем значение вида
			if (undefined !== box.attr('data-ss-pn-v-value'))
				$("input[data-ss-pn-parameter='v']").val(box.attr('data-ss-pn-v-value'));
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по стране)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "страна"
			if ($('#param-country select').length > 0) {
				// удаляем выбранную страну
				$("input[data-ss-pn-parameter='country']").remove();
				// если значение не пустое
				if ($('#param-country select').val() != '')
					// создаем новую страну
					$('#param-country select').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="country"'
							+ ' value="' + $('#param-country select').val() + '"'
						+ '>'
					);
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по тегу)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "теги"
			if ($('#param-tag select').length > 0) {
				// удаляем выбранный тег
				$("input[data-ss-pn-parameter='tag']").remove();
				// если значение не пустое
				if ($('#param-tag select').val() != '')
					// создаем новый тег
					$('#param-tag select').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="tag"'
							+ ' value="' + $('#param-tag select').val() + '"'
						+ '>'
					);
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по статусу)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "статусы"
			if ($('#param-status select').length > 0) {

				// хук позволяющий скорректировать лист параметров
				$('body').trigger('ss.pn.submit-status', [box]);

				// удаляем выбранный статус
				$("input[data-ss-pn-parameter='status']").remove();
				// если значение не пустое
				if ($('#param-status select').val() != '')
					// создаем новый статус
					$('#param-status select').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="status"'
							+ ' value="' + $('#param-status select').val() + '"'
						+ '>'
					);
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по букмекеру)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "букмекеры"
			if ($('#param-bookmaker select').length > 0) {
				// удаляем выбранного букмекера
				$("input[data-ss-pn-parameter='bookmaker']").remove();
				// если значение не пустое
				if ($('#param-bookmaker select').val() != '')
					// создаем нового букмекера
					$('#param-bookmaker select').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="bookmaker"'
							+ ' value="' + $('#param-bookmaker select').val() + '"'
						+ '>'
					);
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по капперу)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "капперы"
			if ($('#param-capper select').length > 0) {
				// удаляем выбранный каппер
				$("input[data-ss-pn-parameter='capper']").remove();
				// если значение не пустое
				if ($('#param-capper select').val() != '')
					// создаем нового каппера
					$('#param-capper select').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="capper"'
							+ ' value="' + $('#param-capper select').val() + '"'
						+ '>'
					);
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по турниру)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "турниры"
			if ($('#param-tournament > a input').length > 0) {
				// активный чекбокс
				var input = (function () {
					// если тык был по чекбоксу, а не по др элементу
					if (box[0].tagName == 'INPUT')
						return box;

					// если по др элементу, то пытаемся найти активный чекбокс
					var input = null;
					$('#param-tournament > a input').each(function () {
						// если нашли
						if (true === $(this).prop('checked'))
							// сохраняем
							input = $(this);
					});

					// вертаем чекбокс или нулл
					return input;
				})();

				// статус чекбокса
				var active = (function () {
					if (null === input)
						return false;

					return input.prop('checked');
				})();

				// удаляем выбранный турнир
				$("input[data-ss-pn-parameter='tournament']").remove();

				// удаляем активность чекбоксов
				$('#param-tournament > a input').prop('checked', false);

				// если турнир был выбран
				if (null !== input && true === active) {
					// активируем чекбокс
					input.prop('checked', true);

					// создаем новый турнир
					$('#param-tournament > a:last-child').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="tournament"'
							+ ' value="' + input.val() + '"'
						+ '>'
					);
				}
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (фильтр по типу)
		 *
		 */

		$('body').bind('ss.pn.submit', function(e, box) {
			// если есть параметр "типы"
			if ($('#param-type > a input').length > 0) {
				// активный чекбокс
				var input = (function () {
					// если тык был по чекбоксу, а не по др элементу
					if (box.attr('data-ss-filter-checkbox') == 'type')
						return box;

					// если по др элементу, то пытаемся найти активный чекбокс
					var input = null;
					$('#param-type > a input').each(function () {
						// если нашли
						if (true === $(this).prop('checked'))
							// сохраняем
							input = $(this);
					});

					// вертаем чекбокс или нулл
					return input;
				})();

				// статус чекбокса
				var active = (function () {
					if (null === input)
						return false;

					return input.prop('checked');
				})();

				// удаляем выбранный тип
				$("input[data-ss-pn-parameter='type']").remove();

				// удаляем активность чекбоксов
				$('#param-type > a input').prop('checked', false);

				// если тип был выбран
				if (null !== input && true === active) {
					// активируем чекбокс
					input.prop('checked', true);

					// создаем новый тип
					$('#param-type > a:last-child').after(''
						+ '<input'
							+ ' type="hidden"'
							+ ' data-ss-pn-parameter="type"'
							+ ' value="' + input.val() + '"'
						+ '>'
					);
				}
			}
		});

		/**
		 * событие "произошла отправка" данных для
		 * постранички (постраничка)
		 *
		 */

		$('body').bind('ss.pn.submit', function (e, box) {
			// если есть параметр "страница"
			if ($("input[data-ss-pn-parameter='page']").length > 0) {
				// переназначаем значение страницы, если клик произвели по постраничке
				if (undefined !== box.attr('data-ss-pn-page-value'))
					$("input[data-ss-pn-parameter='page']").val(box.attr('data-ss-pn-page-value'));

				else
					// сбрасываем страницу
					$("input[data-ss-pn-parameter='page']").val(1);
			}
		});

		/**
		 * событие "заменить урл" для
		 * постранички (выбор дня по кнопка <>)
		 *
		 */

		$('body').bind('ss.pn.history.replace', function (e, box) {
			if (box.attr('data-ss-pn-day-value') == 'prev') {
				b_calendar_prev();
			}

			else if (box.attr('data-ss-pn-day-value') == 'next') {
				b_calendar_next();
			}
		});

		/**
		 * следующий день в календаре
		 *
		 */

		$('.b-filter-top__calendar .b-calendar__nav-next').bind('click', function () {
			b_calendar_next();
		})

		/**
		 * предыдущий день в календаре
		 *
		 */

		$('.b-filter-top__calendar .b-calendar__nav-prev').bind('click', function () {
			b_calendar_prev();
		});

		/**
		 * событие vue фильтра "шаблоны загрузились"
		 *
		 */

		$('body').bind('ss.loaded.vue-filter', function () {
			b_calendar_nav();
		});

		/**
		 * событие "шаблоны загрузились"
		 *
		 */

		$('body').bind('ss.loaded.vue-filter', function () {
			// активируем бинд пагинации
			$('body').trigger('ss.pn.reloaded');
		});

		/**
		 * событие перезагрузки контента МЦ
		 *
		 */

		$('body').bind('ss.pn.matches.update', function (e, data) {
			// парсим json массив
			data = JSON.parse(data);

			// заполняем опции
			// туринры которые нужно раскрыть
			setOptions(
				'tournaments',
				ssVueFilter().options,
				(data.dataset.length > 0) ? data.dataset[0]['tournaments'] : []
			);

			// виды спорта
			setOptions('sport', ssVueFilter().options, data.options.sport);

			// турнир
			setOptions('tournament', ssVueFilter().options, data.options.tournament);

			// статус
			setOptions('status', ssVueFilter().options, data.options.status);

			// список матчей
			ssVueFilter().data.dataset.splice(0, ssVueFilter().data.dataset.length);
			for (var i in data.dataset)
				ssVueFilter().data.dataset.push(
					data.dataset[i]
				);

			// спорт
			ssVueFilter().data.parameters.sports.splice(0, ssVueFilter().data.parameters.sports.length);
			for (var i in data.parameters.sports)
				ssVueFilter().data.parameters.sports.push(
					data.parameters.sports[i]
				);

			// статусы
			ssVueFilter().data.parameters.statuses.splice(0, ssVueFilter().data.parameters.statuses.length);
			for (var i in data.parameters.statuses)
				ssVueFilter().data.parameters.statuses.push(
					data.parameters.statuses[i]
				);

			// мои лиги
			ssVueFilter().data.parameters.tournaments.splice(0, ssVueFilter().data.parameters.tournaments.length);
			for (var i in data.parameters.tournaments)
				ssVueFilter().data.parameters.tournaments.push(
					data.parameters.tournaments[i]
				);
		});

		/**
		 * событие перед монтированием верхнего фильтра
		 *
		 */

		$('body').bind('ss.top.beforemount.vue-filter', function (e, filter, options) {
			setOptions(
				'day',
				options,
				$('#ss-vue-filter-current-day').text() == 'false' ? false : $('#ss-vue-filter-current-day').text()
			);

			setOptions(
				'sport',
				options,
				$('#ss-vue-filter-current-sport').text() == 'false' ? false : $('#ss-vue-filter-current-sport').text()
			);
		});

		/**
		 * событие перед монтированием левого фильтра
		 *
		 */

		$('body').bind('ss.left.beforemount.vue-filter', function (e, filter, options) {
			setOptions(
				'tournament',
				options,
				$('#ss-vue-filter-current-tournament').text() == 'false' ? false : $('#ss-vue-filter-current-tournament').text()
			);

			setOptions(
				'status',
				options,
				$('#ss-vue-filter-current-status').text() == 'false' ? false : $('#ss-vue-filter-current-status').text()
			);
		});

		/**
		 * событие перед монтированием списка турниров
		 *
		 */

		$('body').bind('ss.list.beforemount.vue-filter', function (e, filter, options) {

			setOptions(
				'tournaments',
				options,
				(filter.data['dataset'].length > 0) ? filter.data['dataset'][0]['tournaments'] : []
			);

			/**
			 * компонент турнира
			 *
			 */

			Vue.component('tournament', {
				props: [
					'tournament',
					'is_top',
					'collapsed'
				],
				template: '#ss-vue-filter-component-tournament'
			});
		});

		/**
		 * событие "после обновление приложения vue"
		 *
		 */

		$('body').bind('ss.left.updated.vue-filter', function () {
			$('body').trigger('ss.pn.reloaded');
		});

		b_calendar_nav();
	});
})(jQuery);
