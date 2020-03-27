/**
 * @name SiteSet Scrollbar JS
 * @version 1.3
 * @author Alexey Glumov
 * @copyright Copyright (c) 2018 SoftArt Internet Company http://softart.ru
 */

/**
 * переменная хранит поднятые
 * скроллы
 *
 * @var array
 */

var ssVariableScrollbars = [];

/**
 * функция для быстрого
 * создания объекта класса
 *
 * @return ssScrollbarClass
 *
 * @param object options
 */

function ssScrollbar(options)
{
	var bar	= new ssScrollbarClass(options);
	ssVariableScrollbars.push(bar);

	return bar;
}

/**
 * скролл
 *
 * @var object options
 */

function ssScrollbarClass(options)
{
	/**
	 * блок для которого необходимо
	 * сгенерировать скролл
	 *
	 * @var jquery
	 */

	this.block = options.block;

	/**
	 * вложенный блок
	 *
	 * @var jquery
	 */

	this.inner = options.inner;

	/**
	 * объект хранит
	 * горизонтальный и вертикальный
	 * скроллбары
	 *
	 * @var object
	 */

	this.scroll = {};

	/**
	 * необходимый тип скроллбара.
	 * поддержка
	 * - horizontally горизонтальный
	 * - vertically вертикальный
	 * - all сразу оба
	 *
	 * @var string
	 */

	this.type = (options.type === undefined) ? 'vertically' : options.type;

	/**
	 * координата X при клике на скролл
	 *
	 * @var integer
	 */

	this.startX = 0;

	/**
	 * координата Y при клике на скролл
	 *
	 * @var integer
	 */

	this.startY = 0;

	/**
	 * id интервала
	 *
	 * @var integer
	 */

	this.id;

	/**
	 * кол-во милисекунд в состояние
	 * движения
	 *
	 * @var integer
	 */

	this.milliseconds = 0;

	/**
	 * высоты общего и вложенного
	 * блока
	 *
	 * @var object
	 */

	this.height = {};

	/**
	 * широты общего и вложенного
	 * блока
	 *
	 * @var object
	 */

	this.width = {};

	/**
	 * стартовая позиция скролла
	 *
	 * @var object
	 */

	this.position = {
		scroll: {
			top:	0,
			left:	0
		},
		inner: {
			top:	0,
			left:	0
		}
	};

	/**
	 * инициализация скролла
	 *
	 */

	this.init = function () {

		// устанавливаем триггер
		self.block.trigger('ssScrollbarInit', [self]);

		// помечаем блоки
		self.block.addClass('ss-scrollbar-block');
		self.inner.addClass('ss-scrollbar-inner');

		// устанавливаем событие на тач
		self.block.bind('touchstart mousedown', function (e) {
			return self.touchdown(e);
		});

		// если еще небыло ниодной инициализации
		if (!$('body').hasClass('ss-scrollbar-init')) {

			// создаем флаг инициализации
			$('body').addClass('ss-scrollbar-init');

			// устанавливаем событие на антач
			$(document).bind('touchend mouseup', function (e) {
				for (var i in ssVariableScrollbars)
					if(ssVariableScrollbars[i].block.hasClass('ss-scrollbar-busy'))
						ssVariableScrollbars[i].touchup(e);
			});
		};

		// блоки

		// высота окна и бара
		self.height = {
			'block':	self.block.innerHeight(),
			'inner':	( (self.inner.innerHeight() - self.block.innerHeight()) <= 0 ? 0 : (self.inner.innerHeight() - self.block.innerHeight()) )
		};

		// ширина окна и бара
		self.width = {
			'block':	self.block.innerWidth(),
			'inner':	( (self.inner.innerWidth() - self.block.innerWidth()) <= 0 ? 0 : (self.inner.innerWidth() - self.block.innerWidth()) )
		};

		// бары
		self.setbar();

		// установка стартовой позиции
		self.setposition()

		// устанавливаем триггер
		self.block.trigger('ssScrollbarInited', [self]);
	};

	/**
	 * установка стартовой позиции
	 * скролла
	 *
	 */

	this.setposition = function () {
		var setVertically = function () {
			if (self.height.inner === 0)
				return false;

			// расчитываем сдвиг по top у блока
			var inner = parseInt(self.position.inner.top);
			if (inner < 0 && Math.abs(inner) > self.height.inner)
				inner = '-' + parseInt(self.height.inner);

			// расчитываем сдвиг по top у скролла
			var scroll = parseInt(self.position.scroll.top);
			var height = parseInt(self.scroll.vertical.css('height'));
			if ((scroll + height) > self.height.block)
				scroll = self.height.block - height;

			// устанавливаем позиции
			// бар
			self.inner.css({
				'margin-top': inner + 'px'
			});

			// скролл бар
			self.scroll.vertical.css({
				'margin-top': scroll + 'px'
			});
		};

		var setHorizontal = function () {
			if (self.width.inner === 0)
				return false;

			// расчитываем сдвиг по left у блока
			var inner = parseInt(self.position.inner.left);
			if (inner < 0 && Math.abs(inner) > self.widht.inner)
				inner = '-' + parseInt(self.widht.inner);

			// расчитываем сдвиг по left у скролла
			var scroll	= parseInt(self.position.scroll.left);
			var width	= parseInt(self.scroll.horizontal.css('width'));
			if ((scroll + width) > self.width.block)
				scroll = self.width.block - width;

			// устанавливаем позиции
			// бар
			self.inner.css({
				'margin-left': inner + 'px'
			});

			// скролл бар
			self.scroll.horizontal.css({
				'margin-left': scroll + 'px'
			});
		};

		// установка по вертикаль
		setVertically();

		// установка по горизонтали (!!! не тестировалось)
		setHorizontal();
	};

	/**
	 * формирование скроллбара
	 *
	 */

	this.setbar = function () {

		//
		self.block.css({
			'position': 'relative'
		});

		// вертикальный
		var setVertical = function () {
			// если нечего двигать
			if (self.height.inner === 0)
				return;

			// вертикальный скролл
			self.block.append(''
				+ '<div class="ss-scrollbar-vertically">'
					+ '<div class="ss-scrollbar-vertically-bar"></div>'
				+ '</div>'
			);

			// основной блок
			self.block.find('.ss-scrollbar-vertically').css({
				'height': self.height.block + 'px'
			});

			// скролл бар
			self.scroll.vertical = self.block.find('.ss-scrollbar-vertically-bar');
			self.scroll.vertical.css({
				'height':	parseInt(self.block.find('.ss-scrollbar-vertically').innerHeight() / ((self.height.inner + self.height.block) / self.height.block)) + 'px',
				'position':	'absolute'
			});
		};

		// горизонтальный
		var setHorizontal = function () {
			// если нечего двигать
			if (self.width.inner === 0)
				return;

			// горизонтальный скролл
			self.block.append(''
				+ '<div class="ss-scrollbar-horizontally">'
					+ '<div class="ss-scrollbar-horizontally-bar"></div>'
				+ '</div>'
			);

			// основной блок
			self.block.find('.ss-scrollbar-horizontally').css({
				'width': self.width.block + 'px'
			});

			// скролл бар
			self.scroll.horizontal = self.block.find('.ss-scrollbar-horizontally-bar');
			self.scroll.horizontal.css({
				'width':	parseInt(self.block.find('.ss-scrollbar-horizontally').innerWidth() / ((self.width.inner + self.width.block) / self.width.block)) + 'px',
				'position':	'absolute'
			});
		};

		// оба
		var setAll = function () {
			setVertical();
			setHorizontal();
		};

		// устанавливаем бар и скролл бар
		switch (self.type) {
			case 'horizontally':
				setHorizontal();
				break;

			case 'vertically':
				setVertical();
				break;

			case 'all':
				setAll();
				break;
		}


	};

	/**
	 * перезагрузка скролла
	 *
	 */

	this.reboot = function () {
		// останавливаем скрипт
		self.stop();

		// перезапускаем инициализацию
		self.init();
	};

	/**
	 * остановка скролла
	 *
	 */

	this.stop = function () {
		// устанавливаем триггер
		self.block.trigger('ssScrollbarStop', [self]);

		// сохраняем позиции
		self.position.inner.top		= parseInt(self.inner.css('margin-top'));
		self.position.inner.left	= parseInt(self.inner.css('margin-left'));
		self.position.scroll.top	= (undefined !== self.scroll.vertical)		? parseInt(self.scroll.vertical.css('margin-top'))		: 0;
		self.position.scroll.left	= (undefined !== self.scroll.horizontal)	? parseInt(self.scroll.horizontal.css('margin-left'))	: 0;

		// чистим отметки блока
		self.block.removeClass('ss-scrollbar-block');
		self.inner.removeClass('ss-scrollbar-inner');

		// отключаем события (все кроме того что висит на
		// документе)
		self.block.unbind('touchstart');
		self.block.unbind('touchmove');
		self.block.unbind('mousedown');
		self.block.unbind('mousemove');

		// останавливаем счетчик движения
		clearInterval(self.id);

		// сбрасываем свойства
		self.milliseconds	= 0;
		self.startX			= 0;
		self.startY			= 0;
		self.height			= {};
		self.width			= {};
		self.scroll 		= {};
		self.move			= false;
		self.touch			= false;

		// удаляем скроллбары
		self.block.find('.ss-scrollbar-vertically')		.remove();
		self.block.find('.ss-scrollbar-horizontally')	.remove();

		// удаляем заглушку
		self.block.find('.ss-scrollbar-stub')			.remove();

		// сбрасываем позиции
		self.inner.css({
			'margin-top':	'',
			'margin-left':	''
		});

		// устанавливаем триггер
		self.block.trigger('ssScrollbarStoped', [self]);
	};

	/**
	 * поведение при "нажал"
	 *
	 * @param object e объект события
	 */

	this.touchdown = function (e) {
		// ставим флаг занятости
		self.block.addClass('ss-scrollbar-busy');

		// биндим событие на движение пальцем или мышью
		self.block.bind('touchmove mousemove', function (e) {
			self.touchmove(e);
		});

		// запускаем счетчик нахождения в движение
		self.milliseconds = 0;
		self.id = setInterval(function () {
			self.milliseconds += 1;
		}, 1)

		// сохраняем стартовые координаты
		self.startX	= self.coord(e).x;
		self.startY	= self.coord(e).y;

		return false;
	};

	/**
	 * поведение при "отпустил"
	 *
	 * @param object e объект события
	 */

	this.touchup = function (e) {
		// удаляем флаг занятости
		self.block.removeClass('ss-scrollbar-busy');

		// останавливаем счетчик движения
		clearInterval(self.id);

		// отключаем событие движения
		self.block.unbind('touchmove');
		self.block.unbind('mousemove');

		// задержка перед удалением заглушки
		setTimeout(function () {
			// если "отпустил" было запущено с телефона и при этом
			// небыло заглушки
			if (e.type === 'touchend' && self.block.find('.ss-scrollbar-stub').length === 0)
				// если событие было в пределах скролла
				if ($(e.target).parents('.ss-scrollbar-inner').length > 0)
					// производим принудительное событие "клик"
					e.target.click();

			// удаляем заглушку
			self.block.find('.ss-scrollbar-stub').remove();
		}, 50);
	};

	/**
	 * поведение при "тащим"
	 *
	 * @param object e объект события
	 */

	this.touchmove = function (e) {
		// сбрасываем выделение
		if (window.getSelection)
			window.getSelection().removeAllRanges();

		else if (document.selection && document.selection.clear)
			document.selection.clear();

		// если состояние "нажал" продолжается более 30 миллисек
		// и нет заглушки
		if (self.milliseconds > 30 && self.block.find('.ss-scrollbar-stub').length === 0)
			// ставим заглушку
			self.inner.append(
				$('<div class="ss-scrollbar-stub"></div>').css({
					'height':	self.inner.innerHeight() + 'px',
					'width':	self.inner.innerWidth() + 'px',
					'position':	'absolute',
					'cursor':	'move',
					'left':		0,
					'top':		0
				})
			);

		// двигаем бар
		self.movebar(e);
	};

	/**
	 * анимация движения
	 *
	 * @param object e объект события
	 */

	this.movebar = function (e) {
		// можно ли производить анимацию
		if (!self.canmove(e, self.type))
			return;

		var setVertically = function () {
			// сдвиг по оси y
			var shiftY	= self.startY - self.coord(e).y;
			// текщая позиция блока
			var nowY	= parseInt(self.inner.css('margin-top'));
			// новая позиция блока
			var newY	= ((shiftY >= 0) ? nowY - Math.abs(shiftY) : nowY + Math.abs(shiftY) );

			// бар
			self.inner.css({
				'margin-top': ( (newY > 0) ? 0 : (Math.abs(newY) > self.height.inner ? '-' + self.height.inner : newY) ) + 'px'
			});

			// скролл бар
			self.scroll.vertical.css({
				'margin-top': (
					(newY > 0) ? 0 : Math.abs(newY / ((self.height.inner + self.height.block) / self.height.block))
				) + 'px'
			});
		};

		var setHorizontally = function () {
			// сдвиг по оси x
			var shiftX	= self.startX - self.coord(e).x;
			// текщая позиция блока
			var nowX	= parseInt(self.inner.css('margin-left'));
			// новая позиция блока
			var newX	= ((shiftX >= 0) ? nowX - Math.abs(shiftX) : nowX + Math.abs(shiftX) );

			// бар
			self.inner.css({
				'margin-left': ( (newX > 0) ? 0 : (Math.abs(newX) > self.width.inner ? '-' + self.width.inner : newX) ) + 'px'
			});

			// скролл бар
			self.scroll.horizontal.css({
				'margin-left': (
					(newX > 0) ? 0 : Math.abs(newX / ((self.width.inner + self.width.block) / self.width.block))
				) + 'px'
			});
		};

		// устанавливаем бар и скролл бар
		switch (self.type) {
			case 'horizontally':
				setHorizontally();
				break;

			case 'vertically':
				setVertically();
				break;

			case 'all':
				if (self.canmove(e, 'vertically'))
					setVertically();

				if (self.canmove(e, 'horizontally'))
					setHorizontally();
				break;
		}

		// пересохраняем изначальные данные
		self.startX	= self.coord(e).x;
		self.startY	= self.coord(e).y;
	}

	/**
	 * можно ли производить анимацию
	 *
	 * @return boolean
	 *
	 * @param object e объект события
	 * @param string type тип анимации
	 */

	this.canmove = function (e, type) {

		var canVertically = function (e) {
			// текущее положение блока
			var nowY = parseInt(self.inner.css('margin-top'));

			// если нечего двигать
			if (self.height.inner === 0)
				return false;

			// если бар не двигался
			if ('notmoving' === self.where(e).y)
				return false;

			// если двигаемся вниз
			if ('bottom' === self.where(e).y)
				if (Math.abs(nowY) == self.height.inner)
					return false;

			// если двигаемся вверх
			if ('top' === self.where(e).y)
				if (nowY == 0)
					return false;

			return true;
		};

		var canHorizontally = function (e) {
			// текущее положение блока
			var nowX = parseInt(self.inner.css('margin-left'));

			// если нечего двигать
			if (self.width.inner === 0)
				return false;

			// если бар не двигался
			if ('notmoving' === self.where(e).x)
				return false;

			// если двигаемся в лево
			if ('left' === self.where(e).x)
				if (nowX == 0)
					return false;

			// если двигаемся в право
			if ('right' === self.where(e).x)
				if (Math.abs(nowX) == self.width.inner)
					return false;

			return true;
		};

		switch (type) {
			case 'horizontally':
				return canHorizontally(e);

			case 'vertically':
				return canVertically(e);

			case 'all':
				return (true === canVertically(e) || true === canHorizontally(e));
		}
	};

	/**
	 * направление движения
	 *
	 * @return object
	 *
	 * @param object e объект события
	 */

	this.where = function (e) {
		// получаем сдвиг по оси x и y
		var shiftX	= self.startX - self.coord(e).x;
		var shiftY	= self.startY - self.coord(e).y;

		// возвращаем направление движения
		return {
			'x': ( (shiftX <= 0) ? ((shiftX == 0) ? 'notmoving' : 'left')	: 'right' ),
			'y': ( (shiftY <= 0) ? ((shiftY == 0) ? 'notmoving' : 'top')	: 'bottom' )
		};
	}

	/**
	 * текущее положение мыши или пальца
	 *
	 * @return object
	 *
	 * @param object e объект события
	 */

	this.coord = function (e) {

		var touch = {};

		switch (e.type) {
			// если с ПК
			case 'mousedown':
			case 'mouseup':
			case 'mousemove':
			case 'click':
				touch.x = e.pageX;
				touch.y = e.pageY;
				break;

			// если с телефона
			case 'touchstart':
			case 'touchend':
			case 'touchmove':
				touch.x = (e.originalEvent.touches[0] || e.originalEvent.changedTouches[0]).pageX;
				touch.y = (e.originalEvent.touches[0] || e.originalEvent.changedTouches[0]).pageY;
				break;
		}

		return {
			'x': Math.round(touch.x),
			'y': Math.round(touch.y)
		};
	};

	/**
	 * глоб переменная
	 *
	 * @var ssScrollbarClass
	 */

	var self = this;

	/**
	 * запуск инициализации
	 *
	 */

	self.init();
}
