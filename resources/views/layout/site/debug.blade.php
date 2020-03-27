<!DOCTYPE html>
<html class="html-popup" lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>DEBUG</title>
	<meta name="format-detection" content="telephone=no">
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script>
		/**
		 * @name SiteSet Mask JS
		 * @version 0.0.2
		 * @author Alexey Glumov
		 * @copyright Copyright (c) 2020 SoftArt Internet Company http://softart.ru
		 */

		(function($) {
			$.fn.mask = function(mask) {

				/**
				 * старт курсора (курсор устанавливается
				 * к первой заглушке)
				 *
				 * @var integer
				 */

				var start;

				/**
				 * флаг факта удаления
				 *
				 * @var boolean
				 */

				var backspace = false;

				/**
				 * обработчик для вводных даных
				 *
				 * @var function
				 */

				var handler;

				/**
				 * заглушка для маски (пустой символ)
				 *
				 * @var string
				 */

				var stub = '_';

				/**
				 * конструктор
				 *
				 */

				var init = function () {

					// определяем стартовую позицию курсора
					start = getDefault().length == getLength() ? nextSymbol(0, true).cursor : getLength();

					// устанавливаем плейсхолдер
					input.attr('placeholder', getDefault());

					/**
					 * клик по инпуту
					 *
					 */

					input.bind('click', function() {
						setCursor(
							getCursor(input[0].selectionStart)
						);
					});

					/**
					 * фокус на инпут
					 *
					 */

					input.bind('focus', function() {
						if (input.val() == '')
							input.val(getDefault());
					});

					/**
					 * нажате клавиши
					 *
					 */

					input.bind('keydown', function(e) {
						var c = parseInt(input[0].selectionStart);

						switch (e.keyCode) {
							case 37:
								if ((c - 1) < start)
									setCursor(start + 1);

								// если предыдущий символ хрень
								else if (prevSymbol(c).mask != '9' && prevSymbol(c).mask != '#')
									setCursor(prevSymbol(c, true).cursor + 1);
								break;

							case 39:
								// если след символ хрень
								if (nextSymbol(c + 1).mask != '9' && nextSymbol(c + 1).mask != '#')
									setCursor(nextSymbol(c + 1, true).cursor - 1);
								break;

							case 8:
								backspace = true;
								break;

							default:
								backspace = false;
								break;
						}
					});

					/**
					 * изменение инпута
					 *
					 */

					input.bind('input', function() {
						var c		= input[0].selectionStart;
						var ignore	= false;

						// если удаление
						if (true === backspace && c > start && prevSymbol(c + 1).mask != '9' && prevSymbol(c + 1).mask != '#')
							ignore = prevSymbol(c, true).cursor;

						input.val((function () {
							var mask_characters		= mask.split('');
							var result				= [];
							var key					= 0;

							for (var m in mask_characters) {

								// если включен игнор
								if (false !== ignore && m == ignore) {
									// подставляем заглушку
									result.push(stub);

									// сдвигаем ключ
									key++;

									// отключаем игнор
									ignore = false;
								}

								// если перед нами должна быть цифра
								else if (mask_characters[m] == '9') {
									// если введенный символ является цифрой
									if (false !== getСharacter(key) && /^[0-9]*$/i.test(getСharacter(key)))
										// сохраняем символ
										result.push(getСharacter(key));

									// если нет, обрываем цикл
									else
										result.push(stub);

									// сдвигаем ключ
									key++;
								}

								// если перед нами должна быть буква
								else if (mask_characters[m] == '#') {
									// если введенный символ является буквой
									if (false !== getСharacter(key) && /^[a-zа-яёЁ]*$/i.test(getСharacter(key)))
										// сохраняем символ
										result.push(getСharacter(key));

									// если нет, обрываем цикл
									else
										result.push(stub);

									// сдвигаем ключ
									key++;
								}

								// если все остальное
								else
									// сохраняем символ
									result.push(mask_characters[m]);
							}

							return result.join('');
						})());

						setCursor(
							getCursor(c)
						);
					});

					/**
					 * сброс фокуса с инпута
					 *
					 */

					input.bind('blur', function() {
						if (getDefault() == input.val())
							input.val('');
					});
				};

				/**
				 * запоминаем курсор
				 *
				 */

				var setCursor = function (c) {
					input[0].selectionStart = input[0].selectionEnd = c;
				};

				/**
				 * получаем курсор
				 *
				 * @var integer c текущее положение курсора
				 *
				 * @return integer
				 */

				var getCursor = function (c) {
					// если существует курсор
					if (undefined !== c) {
						// есть ли после курсора введенных данных нет или курсор меньше старта
						if (c < start || nextSymbol(c, true).value == stub)
							// приравниваем курсор к длине
							c = getLength();

						// если после курсора находится "оформление маски" (скобки, тире
						// и всякая др дичь)
						else if (nextSymbol(c).mask != '9' && nextSymbol(c).mask != '#') {
							// то пролистываем до первого введеного символа
							c = nextSymbol(c, true).cursor;
						}
					}

					return (undefined !== c && c >= start && c <= getLength()) ? c : getLength();
				};

				/**
				 * получаем длину заполненной строки
				 *
				 * @return integer
				 */

				var getLength = function () {
					var mask_characters		= mask.split('');
					var value_characters	= input.val() == '' ? getDefault().split('') : input.val().split('');
					var length				= 0;

					for (var m in mask_characters)
						if (
								(mask_characters[m] == '#' || mask_characters[m] == '9')
							&&	value_characters[m] == stub
						) {
							length = parseInt(m);
							break;
						}

					// если маска начинается с спец символов и первый символ заглушка
					if ((mask_characters[0] == '#' || mask_characters[0] == '9') && value_characters[0] == stub)
						// возвращаем длину заполненных символов как есть
						return length;

					// если длина равна нулю, то ворзаращаем длину маски в качестве курсора
					// в противном случае возвращаем длину заполненных символов
					return length === 0 ? mask_characters.length : length;
				};

				/**
				 * если нужно получить просто след символ от курсора,
				 * то вызываем без параметра. если нужно получить символ
				 * для данных то вызываем с параметром true
				 *
				 * @param integer c
				 * @param boolean v
				 *
				 * @return object
				 */

				var nextSymbol = function (c, v) {
					v = undefined === v ? false : v;
					var mask_characters		= mask.split('');
					var value_characters	= input.val().split('');

					for (var m in mask_characters)
						if (parseInt(m) >= c) {
							if (false === v)
								return {
									cursor:	parseInt(m) + 1,
									value:	value_characters[m],
									mask:	mask_characters[m],
								}
							else if (mask_characters[m] == '9' || mask_characters[m] == '#')
								return {
									cursor:	parseInt(m),
									value:	value_characters[m],
									mask:	mask_characters[m]
								};
						}

					return {
						cursor:	mask_characters.length + 1,
						value:	null,
						mask:	null
					};
				};

				/**
				 * если нужно получить просто пред символ от курсора,
				 * то вызываем без параметра. если нужно получить символ
				 * для данных то вызываем с параметром true
				 *
				 * @param integer c
				 * @param boolean v
				 *
				 * @return object
				 */

				var prevSymbol = function (c, v) {
					v = undefined === v ? false : v;
					var mask_characters		= mask.split('');
					var value_characters	= input.val().split('');

					for (var m = mask_characters.length - 1; m >= 0; m--)
						if (parseInt(m) < c) {
							if (false === v)
								return {
									cursor:	parseInt(m),
									value:	value_characters[m],
									mask:	mask_characters[m]
								};

							else if (mask_characters[m] == '9' || mask_characters[m] == '#')
								return {
									cursor:	parseInt(m),
									value:	value_characters[m],
									mask:	mask_characters[m]
								};
						}

					return {
						cursor:	-1,
						value:	null,
						mask:	null
					};
				};

				/**
				 * дефолтное значение (трансформируем маску в значение с
				 * заглушками)
				 *
				 * @return string
				 */

				var getDefault = function () {
					var mask_characters	= mask.split('');
					var result			= [];

					for (var m in mask_characters) {
						if (mask_characters[m] == '9' || mask_characters[m] == '#')
							result.push(stub);

						else
							result.push(mask_characters[m]);
					}

					return result.join('');
				};

				/**
				 * получить символ из вводной строки
				 *
				 * @param integer key позиция в строке
				 *
				 * @return char|false
				 */

				var getСharacter = function (key) {
					return undefined !== getValue().split('')[key] ? getValue().split('')[key] : false;
				};

				/**
				 * получить вводную строку
				 *
				 * @return string
				 */

				var getValue = function () {
					return handler(input.val());
				};

				/**
				 * глоб доступ к инпуту
				 *
				 * @var object
				 */

				var input = $(this);

				/**
				 * глоб доступ к классу
				 *
				 * @var object
				 */

				var slef = this;

				/**
				 * бинд обработчика
				 *
				 * @param function c функция обработки вводных данных
				 */

				this.bind = function(c) {
					handler = c;

					if (input.val() != '')
						input.trigger('input');
				};

				/**
				 * запуск конструктора
				 *
				 */

				init();

				return slef;
			};
		})(jQuery);

		$(document).ready(function () {

			/**
			 * набор обработчиков
			 *
			 * @var object
			 */

			var handlers = {
				// числовое
				'integer': function (value) {
					return value.replace(/[^0-9]/ig, '');
				},

				// строковое
				'string': function (value) {
					return value.replace(/[^a-zа-яёЁ]/ig, '');
				},

				// микс строки
				'mix': function (value) {
					return value.replace(/[^a-zа-яёЁ0-9]/ig, '');
				},

				// по умолчанию
				'phone': function (value) {
					return value.replace(/^(?:\+7)/ig, '').replace(/(?:\+7)/ig, '').replace(/[^0-9]/ig, '');
				},
			};

			$("*[data-mask]").each(function () {
				var mask	= $(this).attr('data-mask');
				var handler	= undefined !== $(this).attr('data-mask-handler') ? $(this).attr('data-mask-handler') : 'phone';

				$(this).mask(mask).bind(handlers[handler]);
			});
		});
	</script>
</head>
<body>
	@yield('content')
</body>
</html><!-- {{ config('app.name') }} v{{ config('app.version') }} -->