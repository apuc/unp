/**
 * класс позволяет работать с фильтром
 * !!! пока работает с инпутами и чекбоксами
 *
 * - data-ss-filter-url			- адрес обработчика
 * - data-ss-filter-input		- поле инпут
 * - data-ss-filter-select		- поле select
 * - data-ss-filter-checkbox	- поле чекбокс
 * - data-ss-filter-button		- кнопка
 *
 * @name SiteSet Filter JS
 * @version 0.0.3
 * @author Alexey Glumov
 * @copyright Copyright (c) 2018 SoftArt Internet Company http://softart.ru
 */

/**
 * класс фильтра
 *
 */

function ssFilterClass()
{
	/**
	 * ссылка на класс ssFilterClass
	 *
	 * @var ssFilterClass
	 */

	var self = this;

	/**
	 * массив параметров урла
	 *
	 * @var array
	 */

	var parameters = [];

	/**
	 * событие использования фильтра
	 *
	 * @param jq box группа параметров
	 */

	this.event = function (box) {
		// блокируем фильтр
		lock(box);

		// отправляет запрос на получения кол-ва позиций
		// и списка доступных параметров
		$.get(getUrl(), {}, function (data) {
			// разблокируем фильтр
			unlock(data);

			// устанавливает счетчик
			setBadge(data);
		}, 'json');
	};

	/**
	 * собирает урл для запроса
	 *
	 * @return string
	 */

	var getUrl = function () {
		var url = $('*[data-ss-filter-url]').attr('data-ss-filter-url');

		// собираем инпуты
		getInput();

		// собираем селекты
		getSelect();

		// собираем чекбоксы
		getCheckbox();

		if (parameters.length > 0) {
			var hash = [];
			for (var i in parameters)
				hash.push(''
					+ parameters[i].parameter
					+ '='
					+ parameters[i].value
				);

			url += '?' + hash.join('&');
		}

		// чистим параметры
		parameters = [];

		return url;
	};

	/**
	 * собирает инпуты
	 *
	 */

	var getInput = function () {
		$("*").each(function () {
			if (undefined === $(this).attr('data-ss-filter-input'))
				return;

			setParameter(
				$(this).attr('data-ss-filter-input'),
				$(this).val()
			);
		});
	};

	/**
	 * собирает селекты
	 *
	 */

	var getSelect = function () {
		$("*").each(function () {
			if (undefined === $(this).attr('data-ss-filter-select'))
				return;

			 if ($(this).val() == '')
				return;

			setParameter(
				$(this).attr('data-ss-filter-select'),
				$(this).val()
			);
		});
	};

	/**
	 * собирает чекбоксы
	 *
	 */

	var getCheckbox = function () {
		$("*").each(function () {
			if (undefined === $(this).attr('data-ss-filter-checkbox'))
				return;

			if (false === $(this).prop('checked'))
				return;

			setParameter(
				$(this).attr('data-ss-filter-checkbox'),
				$(this).val()
			);
		});
	};

	/**
	 * метод позволяет заполнить
	 * массив параметров
	 *
	 * @param parameter имя параметра
	 * @param value значение параметра
	 */

	var setParameter = function (parameter, value) {
		parameters.push({
			parameter:	parameter,
			value:		value
		});
	};

	/**
	 * блокировка фильтра
	 *
	 * @param jq box группа параметров
	 */

	var lock = function (box) {
		$("*").each(function () {
			// если чекбокс
			if (undefined !== $(this).attr('data-ss-filter-checkbox'))
				if (
						undefined === box
					||	$(this).parents("*[id^='param-']").eq(0).attr('id') != box.attr('id')
				)
					// если чекбокс не выбран
					if (false === $(this).prop('checked'))
						// блокируем его
						$(this).prop('disabled', true);

			// селект
			if (undefined !== $(this).attr('data-ss-filter-select'))
				if (
						undefined === box
					||	$(this).parents("*[id^='param-']").eq(0).attr('id') != box.attr('id')
				)
					$(this).find('option').each(function () {
						// если это опция ен заглушка
						if ($(this).attr('value') != '')
							// если опция не выбрана
							if (false === $(this).prop('selected'))
								// блокируем ее
								$(this).prop('disabled', true);
					});
		});
	};

	/**
	 * разблокировка фильтра
	 *
	 * @param array params
	 */

	var unlock = function (params) {
		$("*").each(function () {
			// если чекбокс
			if (undefined !== $(this).attr('data-ss-filter-checkbox'))
				// если чекбокс не выбран
				if (false === $(this).prop('checked')) {
					for (var i in params)
						if (
								$(this).attr('data-ss-filter-checkbox') == params[i].parameter
							&&	$(this).val() == params[i].value
						)
							$(this).prop('disabled', false);
				}

			// селект
			if (undefined !== $(this).attr('data-ss-filter-select'))
				// листаем параметры
				for (var i in params) {
					// если селект совпадает с параметром в данной итерации
					if ($(this).attr('data-ss-filter-select') == params[i].parameter)
						// листаем опции
						$(this).find('option').each(function () {
							// если опция не выбрана и ее значение совпадает с значением
							// параметра
							if (
									false === $(this).prop('selected')
								&&	$(this).attr('value') == params[i].value
							)
								// убираем блок
								$(this).prop('disabled', false);
						});
				}
		});
	};

	/**
	 * метод устанавливает счетчик на кнопку
	 * "показать"
	 *
	 * @param array params
	 */

	var setBadge = function (params) {

		/**
		 * помогает вытащить параметр с кол-вом
		 * елементов
		 *
		 * @return integer
		 */

		var count = function () {
			for (var i in params)
				if ('count' === params[i].parameter)
					return params[i].value;

			return 0;
		}

		$('*[data-ss-filter-button]').find('.badge').remove();

		if (count() > 0)
			$('*[data-ss-filter-button]').html(''
				+ $('*[data-ss-filter-button]').eq(0).text()
				+ '<span class="badge">' + count() + '</span>'
			);
	};

	/**
	 * конструктор
	 *
	 */

	var init = function () {
		$("*").each(function () {
			// если инпут или селект
			if (
					undefined !== $(this).attr('data-ss-filter-input')
				||	undefined !== $(this).attr('data-ss-filter-select')
			)
				// биндим событие "change"
				$(this).bind('change', function () {
					var box = $(this).parents("*[id^='param-']").eq(0);

					self.event(box);
				});

			// если чек бокс
			if (undefined !== $(this).attr('data-ss-filter-checkbox'))
				// биндим событие "click"
				$(this).bind('click', function () {
					var box = $(this).parents("*[id^='param-']").eq(0);

					self.event(box);
				});
		});
	};

	// запуск конструктора
	init();
}

/**
 * переменная для хранения объекта
 * класса ssFilterClass
 *
 * @var ssFilterClass
 */

var ssFilterVariable = null;

/**
 * поднимаем объект класса
 * ssFilterClass
 */

$(document).ready(function () {
	ssFilterVariable = new ssFilterClass();

	if ($('*[data-ss-filter-url]').length > 0)
		ssFilter().event();
});

/**
 * быстрый доступ к объекту класса
 * ssFilterClass
 *
 * @return ssFilterClass
 */

function ssFilter()
{
	return ssFilterVariable;
}