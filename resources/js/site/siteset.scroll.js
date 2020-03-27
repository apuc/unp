/**
 * класс позволяет плавно перемещаться по
 * якарям
 *
 * пример:
 *
 * new sitesetScroll().correc(0).scrollTo(
 *      '#anchor',
 *      1500
 * );
 *
 * @name SiteSet Scroll JS
 * @version 1.0.0
 * @author Alexey Glumov
 * @copyright Copyright (c) 2016 SoftArt Internet Company http://softart.ru
 */

function sitesetScroll()
{
	/**
	 * свойство хранит объект
	 * якоря
	 *
	 * @var - object jq
	 */

	this.anchor;

	/**
	 * свойство хранит скорость
	 * анимации в милисек
	 *
	 * @var - integer
	 */

	this.speed = 800;

	/**
	 * свойство хранит сдвиг
	 *
	 * @var - integer
	 */

	this.shift = 0;

	/**
	 * свойство хранит объект с триггерами
	 *
	 * @var - object
	 */

	this.trigger = {};

	/**
	 * метод запускает анимацию
	 *
	 * @param string   anchor - селектор якоря
	 * @param integer  speed  - скорость в милисек.
	 */

	this.scrollTo = function(anchor, speed) {

		// переносим объект класса
		// в локальную переменную
		var self = this;

		// если якорь не передан
		if (anchor == undefined)
			// нефиг тут делать
			return;

		// запоминаем якорь
		self.anchor = $(anchor);

		// если анимация уже работает
		if (self.anchor.hasClass('siteset-scroll-busy'))
			// нефиг тут делать
			return;

		// вставляем флаг позволяющий предотвратить
		// повторный запуск анимации
		self.anchor.addClass('siteset-scroll-busy');

		// если скорость определена
		if (speed != undefined)
			// сохраняем значение
			self.speed = speed;

		// если существует коллбак функция
		if (self.trigger['before'] != undefined)
			// исполняем ее
			self.trigger['before'](self);

		// расчитываем кол-во пикселей от
		// начала страницы до якоря
		var pos = self.anchor.offset().top + self.shift;

		// проигрываем анимацию
		$('html, body').animate(
			{
				scrollTop: pos + 'px'
			},

			self.speed,

			function () {
				if (!self.anchor.hasClass('siteset-scroll-busy'))
					return;

				// удаляем флаг
				self.anchor.removeClass('siteset-scroll-busy');

				// если существует коллбак функция
				if (self.trigger['after'] != undefined)
					// исполняем ее
					self.trigger['after'](self);
			}
		);

	};

	/**
	 * метод запоминает сдвиг на который будет
	 * увеличина прокрутка
	 *
	 * @return this
	 *
	 * @param integer shift - корректирующий сдвиг
	 */

	this.correc = function(shift) {
		this.shift = shift;

		return this;
	};

	/**
	 * метод устанавливает триггерные
	 * функции
	 *
	 * @return this
	 *
	 * @param string   action   - событие (after и before)
	 * @param function callback - коллбак функция
	 */

	this.setTrigger = function(action, callback) {
		if (action != 'after' && action != 'before')
			return this;

		this.trigger[action] = callback;

		return this;
	};
}