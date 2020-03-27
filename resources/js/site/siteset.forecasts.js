/**
 *
 *
 */

function ssForecasts(url, dataset)
{
	return new ssForecastsClass(url, dataset);
}

/**
 *
 *
 *
 */

function ssForecastsClass(url, dataset)
{
	/**
	 *
	 *
	 */

	this.elements = [
		'sports',
		'tournaments',
		'matches',
		'offers',
	];

	/**
	 *
	 *
	 */

	this.load = function () {
		var el	= url.split('/').slice(-1)[0];
		var u	= url.split('/').slice(0, url.split('/').length - 1).join('/');
		var box	= $("*[data-ss-forecasts-" + el + "]");

		if (box.hasClass('ss-forecasts-busy'))
			return;

		box.addClass('ss-forecasts-busy');

		$('*[data-ss-forecasts-form]').fadeTo(0, 0.2, function() {

			box.html('<p class="text-center pb-2 pt-3">Загрузка...</p>');

			$.get(url, dataset, function (content) {
				content = $('<div>' + content + '</div>');

				box.removeClass('ss-forecasts-busy');

				box.replaceWith(content.find("*[data-ss-forecasts-" + el + "]"));

				// чистим другие блоки
				clean(el);

				$('*[data-ss-forecasts-form]').fadeTo(0, 1.0);

				switch (el) {
					case 'sports':
						// если известен выбранный спорт
						// подгружаем турниры спорта
						if (undefined !== dataset.sport_id && dataset.sport_id != '')
							ssForecasts(u + '/tournaments', dataset).load();

						break;

					case 'tournaments':
						// если известен выбранный турнир
						// подгружаем матчи турнира
						if (undefined !== dataset.tournament_id && dataset.tournament_id != '')
							ssForecasts(u + '/matches', dataset).load();

						break;

					case 'matches':
						// если известен выбранный матч
						// подгружаем коэффициенты матча
						if (undefined !== dataset.match_id && dataset.match_id != '')
							ssForecasts(u + '/offers', dataset).load();

						break;

					case 'offers':
						// если подгружаются коэффициенты
						bindOffers(u);
						break;
				}

			}, 'html').fail(function () {

				box.removeClass('ss-forecasts-busy');

				box.replaceWith((function () {
					switch (el) {
						case 'tournaments':
							var message = 'Нет турниров для отображения';
							break;

						case 'matches':
							var message = 'Нет матчей для отображения';
							break;

						case 'offers':
							var message = 'Нет коэффициентов для отображения';
							break;
					}

					return ''
						+ '<div data-ss-forecasts-' + el + '>'
							+ '<div class="alert alert-danger" role="alert">' + message + '</div>'
						+ '</div>'
					;
				})());

				// чистим другие блоки
				clean(el);

				$('*[data-ss-forecasts-form]').fadeTo(0, 1.0);
			});
		});
	};

	/**
	 *
	 *
	 */

	this.save = function () {
		var form		= $('#forecast-form');
		var formData	= new FormData(form[0]);

		if (form.hasClass('ss-forecasts-busy'))
			return;

		form.addClass('ss-forecasts-busy');

		// чистим ошибки
		clearError();

		$('*[data-ss-forecasts-form]').fadeTo(0, 0.2, function() {
			$.ajax({
				type:			'POST',
				url:			url,
				data:			formData,
				cache:			false,
				contentType:	false,
				processData:	false,
				success:		function(answer) {
					location.assign(answer.redirect);
				},
				error: function(answer) {
					$('*[data-ss-forecasts-form]').fadeTo(0, 1.0);

					form.removeClass('ss-forecasts-busy');

					// вставляем ошибки
					setError(
						JSON.parse(answer.responseText)
					);
				}
			});

		});
	};

	/**
	 * устанавливает ошибки
	 *
	 * @param json errors
	 */

	var setError = function (json)
	{
		var form = $('#forecast-form');

		for (field in json.errors) {
			// если блок еще не подсвечен
			if (!form.find("*[name='" + field + "']").hasClass('is-invalid'))
				// подсвечиваем его
				form.find("*[name='" + field + "']").addClass('is-invalid');

			// вставляем ошибку
			$('<div class="invalid-feedback">' + json.errors[field] + '</div>').insertAfter(
				form.find("*[name='" + field + "']")
			);
		}
	};

	/**
	 * чистит ошибки
	 *
	 */

	var clearError = function ()
	{
		var form = $('#forecast-form');

		form.find('.is-invalid').removeClass('is-invalid');
		form.find('.invalid-feedback').remove();
	};

	/**
	 *
	 *
	 *
	 */

	var bindOffers = function (u) {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})

		var type	= undefined !== dataset.type ? dataset.type : '1x2';
		var scope	= undefined !== dataset.scope ? dataset.scope : 'ord';

		ssOffers().setUrl(u + '/' + dataset.match_id);

		$("*[id^='outcomescope-']").bind('ss.offers.loaded', function (e, self, content) {
			if (/outcomescope\-[0-9]+\-[0-9]+$/.test($(this).attr('id'))) {
				// группируем контент
				content = $('<div>' + content + '<div>').find('#nav');

				/**
				 * подсвечиваем коэффициенты
				 *
				 */

				(function () {
					var o;
					var types = content.find('.bets-table tr').eq(0).find('.outcomesubtype').length;

					for (var i = 0; i < types; i++) {
						o = null;
						content.find('.bets-table tr').each(function () {
							if ($(this).find('.odds').length == 0)
								return;

							if ($(this).find('.odds span').length == 0)
								return;

							if (
									null === o
								||	parseFloat($(this).find('.odds').eq(i).find('span').text()) > parseFloat(o.find('span').text())
							)
								o = $(this).find('.odds').eq(i);
						});

						if (null !== o)
							o.addClass('odds-max');
					}
				})();

				// подгружаем контент
				$(this).html('<div data-ss-offers-content>' + content.html() + '<div>');

				// биндим клики по odds
				$(this).find('.odds').each(function () {
					$(this).bind('click', function () {
						$("input[name='bookmaker_id']")	.val($(this).attr('data-ss-forecasts-offer-bookmaker-id'));
						$("input[name='outcome_id']")	.val($(this).attr('data-ss-forecasts-offer-outcome-id'));
						$("input[name='rate']")			.val($(this).attr('data-ss-forecasts-offer-rate'));

						$('#offers-box').find('table tbody tr td').eq(0).find('img').attr('src', $(this).attr('data-ss-forecasts-offer-bookmaker-picture'));
						$('#offers-box').find('table tbody tr td').eq(0).find('img').attr('alt', $(this).attr('data-ss-forecasts-offer-bookmaker-name'));

						$('#offers-box').find('table tbody tr td').eq(1).text($(this).attr('data-ss-forecasts-offer-rate'));
						$('#offers-box').find('table tbody tr td').eq(2).text($(this).attr('data-ss-forecasts-offer-description'));

						$('#offers-box').removeAttr('hidden');

						$('.bets-box .odds').removeClass('odds-yellow');
						$(this).addClass('odds-yellow')

						$("*[data-ss-forecasts-rate]").removeAttr('hidden');
					});
				});
			}
		});

		// клик по табу 1x2
		$('#outcometype-1-tab').bind('shown.bs.tab', function () {
			$('#outcomescope-1-1-tab').trigger('click');
		});

		// подгрузка при клике 1х2 основное время
		$('#outcomescope-1-1-tab').bind('shown.bs.tab', function () {
			ssOffers('1x2', 'ord').load('#outcomescope-1-1');
		});

		// подгрузка при клике 1х2 первый тайм
		$('#outcomescope-1-2-tab').bind('shown.bs.tab', function () {
			ssOffers('1x2', '1h').load('#outcomescope-1-2');
		});

		// подгрузка при клике 1х2 второй тайм
		$('#outcomescope-1-3-tab').bind('shown.bs.tab', function () {
			ssOffers('1x2', '2h').load('#outcomescope-1-3');
		});



		// клик по табу 1 или 2
		$('#outcometype-2-tab').bind('shown.bs.tab', function () {
			$('#outcomescope-2-1-tab').trigger('click');
		});

		// подгрузка при клике 1 или 2 основное время
		$('#outcomescope-2-1-tab').bind('shown.bs.tab', function () {
			ssOffers('12', 'ord').load('#outcomescope-2-1');
		});

		// подгрузка при клике 1 или 2 первый тайм
		$('#outcomescope-2-2-tab').bind('shown.bs.tab', function () {
			ssOffers('12', '1h').load('#outcomescope-2-2');
		});

		// подгрузка при клике 1 или 2 второй тайм
		$('#outcomescope-2-3-tab').bind('shown.bs.tab', function () {
			ssOffers('12', '2h').load('#outcomescope-2-3');
		});



		// клик по табу ди
		$('#outcometype-6-tab').bind('shown.bs.tab', function () {
			$('#outcomescope-6-1-tab').trigger('click');
		});

		// подгрузка при клике ди основное время
		$('#outcomescope-6-1-tab').bind('shown.bs.tab', function () {
			ssOffers('dc', 'ord').load('#outcomescope-6-1');
		});

		// подгрузка при клике ди первый тайм
		$('#outcomescope-6-2-tab').bind('shown.bs.tab', function () {
			ssOffers('dc', '1h').load('#outcomescope-6-2');
		});

		// подгрузка при клике ди второй тайм
		$('#outcomescope-6-3-tab').bind('shown.bs.tab', function () {
			ssOffers('dc', '2h').load('#outcomescope-6-3');
		});



		// клик по табу чн
		$('#outcometype-9-tab').bind('shown.bs.tab', function () {
			$('#outcomescope-9-1-tab').trigger('click');
		});

		// подгрузка при клике чн основное время
		$('#outcomescope-9-1-tab').bind('shown.bs.tab', function () {
			ssOffers('oe', 'ord').load('#outcomescope-9-1');
		});

		// подгрузка при клике чн первый тайм
		$('#outcomescope-9-2-tab').bind('shown.bs.tab', function () {
			ssOffers('oe', '1h').load('#outcomescope-9-2');
		});

		// подгрузка при клике чн второй тайм
		$('#outcomescope-9-3-tab').bind('shown.bs.tab', function () {
			ssOffers('oe', '2h').load('#outcomescope-9-3');
		});



		// клик по табу оз
		$('#outcometype-10-tab').bind('shown.bs.tab', function () {
			$('#outcomescope-10-1-tab').trigger('click');
		});

		// подгрузка при клике оз основное время
		$('#outcomescope-10-1-tab').bind('shown.bs.tab', function () {
			ssOffers('bts', 'ord').load('#outcomescope-10-1');
		});

		// подгрузка при клике оз первый тайм
		$('#outcomescope-10-2-tab').bind('shown.bs.tab', function () {
			ssOffers('bts', '1h').load('#outcomescope-10-2');
		});

		// подгрузка при клике оз второй тайм
		$('#outcomescope-10-3-tab').bind('shown.bs.tab', function () {
			ssOffers('bts', '2h').load('#outcomescope-10-3');
		});

		switch (type) {
			case '1x2':
				$('#outcometype-1-tab').trigger('click');
				switch (scope) {
					case '1h':
						$('#outcomescope-1-2-tab').trigger('click');
						break;

					case '2h':
						$('#outcomescope-1-3-tab').trigger('click');
						break;
				}
				break;

			case '12':
				$('#outcometype-2-tab').trigger('click');
				switch (scope) {
					case '1h':
						$('#outcomescope-2-2-tab').trigger('click');
						break;

					case '2h':
						$('#outcomescope-2-3-tab').trigger('click');
						break;
				}
				break;

			case 'dc':
				$('#outcometype-6-tab').trigger('click');
				switch (scope) {
					case '1h':
						$('#outcomescope-6-2-tab').trigger('click');
						break;

					case '2h':
						$('#outcomescope-6-3-tab').trigger('click');
						break;
				}
				break;

			case 'oe':
				$('#outcometype-9-tab').trigger('click');
				switch (scope) {
					case '1h':
						$('#outcomescope-9-2-tab').trigger('click');
						break;

					case '2h':
						$('#outcomescope-9-3-tab').trigger('click');
						break;
				}
				break;

			case 'bts':
				$('#outcometype-10-tab').trigger('click');
				switch (scope) {
					case '1h':
						$('#outcomescope-10-2-tab').trigger('click');
						break;

					case '2h':
						$('#outcomescope-10-3-tab').trigger('click');
						break;
				}
				break;
		}
	};

	/**
	 *
	 *
	 *
	 */

	var clean = function (el) {
		var a = false;

		for (var i in self.elements) {
			if (self.elements[i] == el)
				a = true;

			else
				if (true === a)
					$("*[data-ss-forecasts-" + self.elements[i] + "]").replaceWith($("<div data-ss-forecasts-" + self.elements[i] + "></div>"));
		}
	}

	/**
	 *
	 *
	 */

	var self = this;
}