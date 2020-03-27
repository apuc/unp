/**
 * класс позволяет перезагрузить страницу с помощью аякса
 * при этом передавая и сохраняя параметры в урле
 *
 * @name SiteSet Product Navigator JS
 * @version 1.2.0
 * @author Alexey Glumov
 * @copyright Copyright (c) 2018 SoftArt Internet Company http://softart.ru
 */

/**
 * класс навигатора товаров
 *
 */

var ssPNClass = function () {

	/**
	 * ссылка на класс ssPNClass
	 *
	 * @var ssPNClass
	 */

	var self = this;

	/**
	 * массив параметров урла
	 *
	 * @var array
	 */

	var parameters = [];

	/**
	 * конструктор (имитация)
	 *
	 */

	var init = function () {
		// исполняем бинд страта релоада
		bindSubmit();

		// исполняем бинд замены адреса
		bindHistoryReplace();

		// слушаем событие "окончание перезагрузки"
		$('body').bind('ss.pn.reloaded ss.pn.history.replaced', function () {
			// исполняем бинд страта релоада
			bindSubmit();

			// исполняем бинд замены адреса
			bindHistoryReplace();
		});
	};

	this.bind = function (event, fun) {
		$('body').addClass('ss-pn-update-content-binded');
		$('body').bind(event, fun);
	};

	/**
	 * метод перезагружает страницу
	 *
	 */

	this.reload = function (dataType) {
		// формат ответа
		dataType = undefined === dataType ? 'html' : dataType;

		// событие "происходит перезагрузка"
		$('body').trigger('ss.pn.reload', [self]);

		self.historyReplace();

		$("*[data-ss-pn-content]").fadeTo(0, 0.2, function() {
			var url = undefined !== $(this).attr('data-ss-pn-url') ? getUrl($(this).attr('data-ss-pn-url')) : getUrl();

			$.get(url, {}, function (data) {

				if (!$('body').hasClass('ss-pn-update-content-binded')) {
					// обновляем контент
					data = $('<div>' + data + '</div>');
					$("*[data-ss-pn-content]").html(
						data.find("*[data-ss-pn-content]").html()
					);
				}
				else
					$('body').trigger('ss.pn.content.update', [data]);

				$("*[data-ss-pn-content]").fadeTo(0, 1.0);

				// событие "окончание перезагрузки"
				$('body').trigger('ss.pn.reloaded', [self]);
			}, dataType)
		});
	};

	/**
	 * метод перезагружает страницу
	 *
	 */

	this.historyReplace = function () {
		// подставляем урл в адресную строку
		window.history.replaceState(
			null,
			null,
			getUrl()
		);

		// событие "окончание смена адреса"
		$('body').trigger('ss.pn.history.replaced', [self]);
	};

	/**
	 * метод возвращает полный урл для
	 * перезагрузки страницы
	 *
	 * @retrun string
	 */

	var getUrl = function (url) {
		url = undefined === url ? location.protocol + '//' + location.hostname + location.pathname : url;

		$("*").each(function () {
			var parameter = $(this).attr('data-ss-pn-parameter');

			// если у блока нет атрибута "параметр"
			if (undefined === parameter)
				// выходим
				return;

			// если перед нами список
			if ($(this)[0].tagName === 'SELECT')
				setParameter(
					parameter,
					$(this).val()
				);

			else if ($(this)[0].tagName === 'INPUT')
				switch($(this).attr('type')) {
					case 'checkbox':
					case 'radio':
						if (true === $(this).prop('checked'))
							setParameter(
								parameter,
								$(this).val()
							);
						break;

					default:
						setParameter(
							parameter,
							$(this).val()
						);
						break;
				}
		});

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
	}

	/**
	 * привязка алгоритма релоада к нужным кнопкам
	 *
	 */

	var bindSubmit = function () {
		// собираем элементы вызывающие релоад
		$("*").each(function () {
			// если у блока нет атрибута запуска релоада
			if (undefined === $(this).attr('data-ss-pn-submit'))
				// выходим
				return;

			// если у блока существует отметка привязки
			if (
					undefined !== $(this).attr('data-ss-pn-submit-binded')
				&&	'true' === $(this).attr('data-ss-pn-submit-binded')
			)
				// выходим
				return;

			$(this).bind($(this).attr('data-ss-pn-submit'), function (e) {
				// событие "произошла отправка"
				$('body').trigger('ss.pn.submit', [$(e.target),self]);

				// запускаем релоад
				self.reload(
					(undefined !== $(e.target).attr('data-ss-pn-return-datatype') ? $(e.target).attr('data-ss-pn-return-datatype') : 'html')
				);
			});

			// ставим пометку, что на блоке висит слушатель
			$(this).attr('data-ss-pn-submit-binded', 'true');
		});
	};

	/**
	 * привязка алгоритма смены истории к нужным кнопкам
	 *
	 */

	var bindHistoryReplace = function () {
		// собираем элементы вызывающие смену адреса
		$("*").each(function () {
			// если у блока нет атрибута запуска смены истории
			if (undefined === $(this).attr('data-ss-pn-history-replace'))
				// выходим
				return;

			// если у блока существует отметка привязки
			if (
					undefined !== $(this).attr('data-ss-pn-history-replace-binded')
				&&	'true' === $(this).attr('data-ss-pn-history-replace-binded')
			)
				// выходим
				return;

			$(this).bind($(this).attr('data-ss-pn-history-replace'), function (e) {
				// событие "произошла смена адреса"
				$('body').trigger('ss.pn.history.replace', [$(e.target),self]);

				// запускаем релоад
				self.historyReplace();
			});

			// ставим пометку, что на блоке висит слушатель
			$(this).attr('data-ss-pn-history-replace-binded', 'true');
		});
	};

	/**
	 * метод позволяет заполнить
	 * массив параметров
	 *
	 * @param parameter имя параметра
	 * @param value значение параметра
	 */

	var setParameter	= function (parameter, value) {
		parameters.push({
			parameter:	parameter,
			value:		value
		});
	};

	/**
	 * запускаем конструктор
	 *
	 */

	init();
};

var ssPNVariable;

$(document).ready(function () {
	// поднимаем класс навигатора
	ssPNVariable = new ssPNClass();
});

function ssPN()
{
	return ssPNVariable;
}