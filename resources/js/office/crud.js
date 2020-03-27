/**
 *
 * @version 1.6
 * 	- добавлена возможность оставлять видимыми
 * 	  предустановленные значения
 *  - ап механизма вывода ошибок
 *  - разблокировка живого списка (если он есть)
 *  - запуск установки масок для полей, при открытие окна
 */

/**
 * переменная для хранения объекта
 * sitesetCRUD
 *
 * @var sitesetCRUD
 */

var ssCRUDVariable = null;

/**
 * вызов sitesetCRUD в виде
 * синглтона
 *
 * @return sitesetCRUD
 */

function ssCRUD()
{
	if (ssCRUDVariable == null) {
		ssEnter().reg(
			function (e) {
				var id   = $(e.target).attr('id');
				var crud = $('#' + id).parents('.ss-crud-form');

				if ($(e.target)[0].tagName == 'TEXTAREA')
					return false;

				return (crud.length > 0) ? true : false;
			},
			'ss-crud',
			98
		)

		ssCRUDVariable = new sitesetCRUD();
	}

	return ssCRUDVariable;
}

/**
 * класс КРУД
 *
 */

function sitesetCRUD()
{
	/**
	 * префикс блоков
	 *
	 * @var string
	 */

	this.box = 'ss-crud';

	/**
	 * координаты мыши
	 *
	 * @var array
	 */

	this.mouse = [];

	/**
	 * событие
	 *
	 * @var string|null
	 */

	this.action = null;

	/**
	 * урл куда нужно произвести редирект
	 *
	 * @var string|null
	 */

	this.redirect = null;

	/**
	 * предустановленные
	 * значения
	 *
	 * @var object
	 */

	this.values = {};

	/**
	 * список установок скрывать ли
	 * предустановленное значение
	 *
	 * @var object
	 */

	this.hidden = {};

	/**
	 * открытые окна
	 *
	 * @var array
	 */

	this.wins = [];

	/**
	 * метод подгружает форму добавления
	 * или редактирования
	 *
	 * @param string route
	 * @param string field поле формы которе
	 *                     инициализировало запуска
	 *                     метода
	 */

	this.load = function (route, field) {

		if (self.action == null)
			return;

		// если лоадми внутренее окно
		if (self.isInnerWin()) {
			if (!field)
				return;

			self.action += '-' + self.wins.length;

			// создаем новое окно
			var nWin = $('#' + self.box + '-tpl-modal').clone();

			nWin.attr('data-load-filed', field);

			nWin.attr('id', self.box + '-' + self.action + '-modal');
			$('#' + self.box + '-tpl-modal').after(
				nWin
			);
		}

		var body   = $('#' + self.box + '-' + self.action + '-modal').find('.modal-body');
		var header = $('#' + self.box + '-' + self.action + '-modal').find('.modal-title');

		$.get(
			route,
			function(content) {
				content = '<div>' + content + '</div>';

				body.html($(content).find('.' + self.box + '-form'));
				header.html($(content).find('title').text());

				// вешаем предустановленные значения
				for (field in self.values) {
					body.find("*[name='" + field + "']").val(self.values[field]);

					if (true === self.hidden[field])
						body.find('#' + field).parents('.form-group').eq(0).addClass('hidden');
				}

				// вешаем обработчик интера на форму
				body.find('form').bind('input keydown', function(event) {
					// если нажали на кнопку интер
					if(event.keyCode == 13 && ssEnter().can(event, 'ss-crud'))
						// отправляем запрос на сохранение
						self.save();
				});

				self.open();
			},
			'html'
		);

	};

	/**
	 * метод выполняет действие после сохранения внутренего
	 * модального окна (либо дейтсвие описанное в функции
	 * scopeSsCRUDимя_поля_которое_актив_модал_окно()
	 * либо по умолчанию)
	 *
	 * @param object answer ответ сервера
	 */

	this.expandField = function (answer) {
		if (!self.isInnerWin())
			return;

		// получаем предыдущее окно
		var win   = $('#' + self.box + '-' + self.wins[self.wins.length - 1].action + '-modal');
		// получаем поле которое активировала внутренее окно
		var field = $('#' + self.box + '-' + self.action + '-modal').attr('data-load-filed');

		var func  = 'scopeSsCRUD' + field;

		// если есть функция обработки поля field
		if (typeof window[func] == 'function')
			window[func](answer);

		// в противном случае обрабатываем по умолчанию
		else {
			if (
				   !answer.id
				|| !answer.name
			)
				return;

			// подставляем id
			win.find("input[name='" + field + "_id']").val(answer.id);

			// подставляем имя
			win.find('#' + field + '_id-' + self.wins[self.wins.length - 1].action + ' input').val(answer.name);

			// убираем блок если есть
			win.find('#' + field + '_id-' + self.wins[self.wins.length - 1].action + ' input').attr('disabled', false);
			win.find('#' + field + '_id-' + self.wins[self.wins.length - 1].action).find('.ss-search-disabled').css('display', 'none');
		}
	};

	/**
	 * метод отправляет форму
	 *
	 */

	this.save = function() {
		var modal		= $('#' + self.box + '-' + self.action + '-modal');
		var form		= $('#' + self.box + '-' + self.action + '-modal').find('form');
		var formData	= new FormData(form[0]);
		var route		= form.attr('action');

		// чистим ошибки
		self.clearError();

		if (form.hasClass(self.box + '-busy'))
			return;

		// закрываем возможность запустить сохранение
		form.addClass(self.box + '-busy');
		modal.find('.' + self.box + '-btn').attr('disabled', true);

		// отправляем запрос
		ssSpin().show(function () {
			$.ajax({
				type:			'POST',
				url:			route,
				data:			formData,
				cache:			false,
				contentType:	false,
				processData:	false,
				success:		function(answer) {
					form.removeClass('busy');

					// если НЕТ внутрених окон
					if (!self.isInnerWin()) {
						// если есть установка куда редиректить
						if (self.redirect !== null) {
							if (typeof self.redirect == 'function')
								self.redirect(answer);

							else
								// производим редирект
								location.assign(
									self.parseString(
										self.redirect,
										answer
									)
								);
						}
						// в противном случае
						else
							// перезагружаем страницу
							location.reload(true);
					}

					else {
						self.expandField(answer);

						ssSpin().hide(function () {
							self.close();
						});
					}
				},
				error: function(answer) {

					ssSpin().hide(function () {
						// разблокируем возможность запустить сохранение
						form.removeClass(self.box + '-busy');
						modal.find('.' + self.box + '-btn').attr('disabled', false);

						// вставляем ошибки
						self.setError(
							JSON.parse(answer.responseText)
						);
					});
				}
			});
		});
	}

	/**
	 * метод удаляет документ
	 *
	 * @param string route
	 * @param string csrf
	 * @param string message
	 * @param function	fn
	 */

	this.destroy = function(route, csrf, message, fn) {

		if (self.action == 'destroy') {
			if (confirm(message))
				self.setAction('true-destroy').destroy(
					route,
					csrf,
					message
				);
			else
				if (undefined !== fn)
					fn();
		}

		else if (self.action == 'true-destroy')
			ssSpin().show(function () {
				$.post(
					route,
					{
						'_token':  csrf,
						'_method': 'DELETE'
					},
					function(answer) {

						// если есть установка куда редиректить
						if (self.redirect !== null) {
							if (typeof self.redirect == 'function')
								self.redirect(answer);

							else
								// производим редирект
								location.assign(
									self.parseString(
										self.redirect,
										answer
									)
								);
						}

						// в противном случае
						else
							// перезагружаем страницу
							location.reload(true);
					}
				);
			});
	}

	/**
	 * метод открывает модальное окно
	 *
	 */

	this.open = function () {
		var open = function () {
			$('#' + self.box + '-' + self.action + '-modal').css('display', 'block');
			$('#' + self.box + '-' + self.action + '-modal').animate(
				{
					paddingTop: '10px',
					opacity:    100
				},
				500,
				function () {
					$('#' + self.box + '-' + self.action + '-modal').fadeTo(0, 100);

					$('#' + self.box + '-' + self.action + '-modal').bind('mousemove', function(e) {
						self.mouse = [e.pageX, e.pageY];
					});

					sitesetGalleryList = new sitesetGallery();
					bindMask();

					//$('#' + self.box + '-' + self.action + '-modal').bind('click', function (e) {
					//	if ($(e.target).attr('id') == $(this).attr('id'))
					//		ssCRUD().close();
					//});
				}
			);
		};

		if (!self.isInnerWin()) {
			$('body').append('<div class="modal-backdrop fade"></div>');
			$('body').addClass('modal-open');
			$('.modal-backdrop').fadeTo(150, 0.5, function () {
				open();
			});
		}
		else {
			self.hide();

			setTimeout(function() {
				var button = $('#' + self.box + '-' + self.action + '-modal').find('.modal-footer button').eq(0);

				if (/\-create-[0-9]+$/.test(self.action))
					button.find('> span').eq(0).removeClass('hidden');
				else
					button.find('> span').eq(1).removeClass('hidden');

				open();
			}, 525);
		}
	};

	/**
	 * метод прячет модальное окно
	 *
	 */

	this.hide = function () {
		// прячем текущее окно
		$('#' + self.box + '-' + self.wins[self.wins.length - 1].action + '-modal').fadeTo(500, 0, function () {
			$('#' + self.box + '-' + self.wins[self.wins.length - 1].action + '-modal').css('display', 'none');
		});
	};

	/**
	 * метод показывает модальное окно
	 *
	 */

	this.show = function () {
		$('#' + self.box + '-' + self.action + '-modal').css('display', 'block');
		$('#' + self.box + '-' + self.action + '-modal').fadeTo(500, 100);
	};

	/**
	 * метод закрывает модальное окно
	 *
	 */

	this.close = function () {
		var close = function (callback) {
			// уничтожаем предустановлденные
			// значения
			self.setValues();

			// уничтожаем установку куда нужно
			// редиректить
			self.setRedirect();

			$('#' + self.box + '-' + self.action + '-modal').animate(
				{
					paddingTop: '0',
					opacity:    0
				},
				500,
				function () {
					$('#' + self.box + '-' + self.action + '-modal').fadeTo(0, 0);
					$('#' + self.box + '-' + self.action + '-modal').unbind('click');
					$('#' + self.box + '-' + self.action + '-modal').css('display', 'none');

					// чистим боди
					$('#' + self.box + '-' + self.action + '-modal').find('.modal-body').html('');

					// чистим заголовок
					$('#' + self.box + '-' + self.action + '-modal').find('.modal-title').html('');

					if (callback)
						callback();
				}
			);
		};

		// если НЕТ внутрених окон
		if (!self.isInnerWin())
			close(function () {
				$('.modal-backdrop').fadeTo(150, 0, function () {
					$('.modal-backdrop').remove();
					$('body').removeClass('modal-open');
				});
			});

		else
			close(function () {
				$('#' + self.box + '-' + self.action + '-modal').remove();
				self.wakeup().show();
			});
	};

	/**
	 * метод парсит строку дополняя ее
	 * переменными
	 *
	 * @param string str
	 * @param object variables
	 */

	this.parseString = function (str, variables) {

		for (variable in variables)
			str = str.replace('{' + variable + '}', variables[variable]);

		return str;
	};


	/**
	 * устанавливает ошибки
	 *
	 * @param json errors
	 */

	this.setError = function (json)
	{
		var form = $('#' + self.box + '-' + self.action + '-modal').find('form');

		for (field in json.errors) {

			// если поле скрыто
			if (form.find('#' + field).parents('.form-group').hasClass('hidden')) {

				form.find('.alert.alert-danger').append(
					'<span class="help-block">' + json.errors[field] + '</span>'
				);

				if (form.find('.alert.alert-danger').parents('.form-group').eq(0).hasClass('hidden'))
					form.find('.alert.alert-danger').parents('.form-group').eq(0).removeClass('hidden');
			}
			else {

				// если блок еще не подсвечен
				if (!form.find('#' + field).parents('.form-group').hasClass('has-error'))
					// подсвечиваем его
					form.find('#' + field).parents('.form-group').addClass('has-error');

				// вставляем ошибку
				$('<span class="help-block">' + json.errors[field] + '</span>').insertAfter(
					form.find('#' + field)
				);
			}
		}
	};

	/**
	 * чистит ошибки
	 *
	 */

	this.clearError = function ()
	{
		var form = $('#' + self.box + '-' + self.action + '-modal').find('form');

		form.find('.alert.alert-danger').parents('.form-group').eq(0).addClass('hidden');
		form.find('.form-group').removeClass('has-error');
		form.find('.help-block').remove();
	};


	/**
	 * метод сохраняет событие
	 *
	 * @return sitesetCRUD
	 *
	 * @param string|null action
	 */

	this.setAction = function (action) {
		self.action = (action) ? action : null;
		return self;
	};

	/**
	 * метод сохраняет маску урла для
	 * редиректа
	 *
	 * @return sitesetCRUD
	 *
	 * @param string|null url
	 */

	this.setRedirect = function (url) {
		self.redirect = (url) ? url : null;
		return self;
	};

	/**
	 * метод сохраняет предустановленное
	 * значение
	 *
	 * @return sitesetCRUD
	 *
	 * @param object values
	 * @param object hidden
	 */

	this.setValues = function (values, hidden) {
		self.values = (values) ? values : {};
		self.hidden = (hidden) ? hidden : {};
		return self;
	};

	/**
	 * метод сохраняет предустановленные
	 * значения
	 *
	 * @return sitesetCRUD
	 *
	 * @param string field
	 * @param mixed value
	 * @param boolean hidden
	 */

	this.setValue = function (field, value, hidden) {
		self.values[field] = value;
		self.hidden[field] = (undefined !== hidden) ? hidden : true;
		return self;
	};

	/**
	 * метод сохраняет текущее состояние
	 * окна
	 *
	 * @return sitesetCRUD
	 */

	this.sleep = function () {
		var ids = {};

		// собираем id полей и портим их, что бы не конфликтовали с новым окном
		$('#' + self.box + '-' + self.action + '-modal').find('*').each(function (i) {
			if ($(this).attr('id') != undefined) {
				ids[i] = $(this).attr('id');
				$(this).attr(
					'id',
					$(this).attr('id') + '-' + self.action
				)
			}
		});

		self.wins.push({
			action:   self.action,
			redirect: self.redirect,
			values:   (self.wins.length == 0 ? self.values : {}),
			hidden:   (self.wins.length == 0 ? self.hidden : {}),
			ids:      ids
		});

		return self;
	};

	/**
	 * метод поднимает предыдущее
	 * окно
	 *
	 * @return sitesetCRUD
	 */

	this.wakeup = function () {
		if (self.wins.length == 0)
			return self;

		// поднимаем состояние
		self
			.setAction  (self.wins[self.wins.length - 1].action)
			.setRedirect(self.wins[self.wins.length - 1].redirect)
			.setValues  (
				self.wins[self.wins.length - 1].values,
				self.wins[self.wins.length - 1].hidden
			)
		;

		// восстанавилваем id полей
		$('#' + self.box + '-' + self.action + '-modal').find('*').each(function (i) {
			if ($(this).attr('id') != undefined)
				$(this).attr(
					'id',
					self.wins[self.wins.length - 1].ids[i]
				);
		});

		// уничтожаем элемент массива
		self.wins.splice(
			self.wins.length - 1,
			1
		);

		return self;
	};

	/**
	 * метод определяет открыто ли внутренее
	 * окно
	 *
	 * @return boolean
	 */

	this.isInnerWin = function () {
		return (self.wins.length == 0) ? false : true;
	};

	/**
	 * глобальная переменнна с
	 * объектом
	 *
	 * @var sitesetCRUD
	 */

	var self = this;
}