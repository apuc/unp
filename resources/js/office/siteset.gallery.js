/**
 * @name SiteSet Gallery JS
 * @version 1.0.1
 * @author Alexey Glumov
 * @copyright Copyright (c) 2016 SoftArt Internet Company http://softart.ru
 */

var sitesetGalleryList;

$(document).ready(function() {
	sitesetGalleryList = new sitesetGallery();
});

function sitesetGallery()
{
	/**
	 * текущее положение курсора на галерее
	 *
	 * @var - integer
	 */

	this.cursor = 0;

	/**
	 * скорость появления окон
	 *
	 * @var - integer
	 */

	this.speed   = 300;

	/**
	 * прозрачность фона
	 *
	 * @var - integer/float
	 */

	this.opacity = 0.8;

	/**
	 * список галерей
	 *
	 * @var - array
	 */

	this.gList = [];

	/**
	 * метод собирает изображения
	 *
	 */

	this.init = function() {

		// удаляем вертску если она есть
		if ($('.siteset-gallery-loader').length > 0)
			$('.siteset-gallery-loader').remove();

		if ($('.siteset-gallery-modal-bg').length > 0)
			$('.siteset-gallery-modal-bg').remove();

		if ($('.siteset-gallery-modal').length > 0)
			$('.siteset-gallery-modal').remove();

		// создаем верстку
		$('body').append(''
			+ '<div class="siteset-gallery-loader"></div>'
			+ '<div class="siteset-gallery-modal-bg"></div>'

			+ '<div class="siteset-gallery-modal">'

				+ '<div class="siteset-gallery-desc"></div>'
				+ '<div class="siteset-gallery-close"></div>'

				+ '<div class="siteset-gallery-switch siteset-gallery-switch-left">'
					+ '<div class="siteset-gallery-switch-left-ico"></div>'
				+ '</div>'
				+ '<div class="siteset-gallery-switch siteset-gallery-switch-right">'
					+ '<div class="siteset-gallery-switch-right-ico"></div>'
				+ '</div>'

				+ '<div class="siteset-gallery-img"></div>'
				+ '<div class="siteset-gallery-count"></div>'
			+ '</div>'
		);

		// событие на закрытие
		$('.siteset-gallery-modal-bg, .siteset-gallery-close').bind('click', function () {
			sitesetGalleryList.close();
		});

		// событие на листание
		$('.siteset-gallery-switch-left').bind('click', function () {
			sitesetGalleryList.prev();
		});

		$('.siteset-gallery-switch-right').bind('click', function () {
			sitesetGalleryList.next();
		});
	};

	/**
	 * метод открывает галерею
	 *
	 */

	this.open = function() {
		var self = this;

		// загружаем изображение
		this.load();

		// поднять фон
		$('.siteset-gallery-modal-bg').fadeTo(self.speed, self.opacity, function () {
			// поднять модальное окно
			$('.siteset-gallery-modal').fadeTo(self.speed, 1, function () {

				// слушаем стрелки влево и вправо и esc
				$(window).bind('keydown', function(e) {
					switch (e.keyCode) {
						case 27:
							sitesetGalleryList.close();
							break;

						case 37:
							sitesetGalleryList.prev();
							break;

						case 39:
							sitesetGalleryList.next();
							break;
					}
				});

			});
		});
	};

	/**
	 * метод загружает фото
	 *
	 */

	this.load = function() {
		// расчитываем скролл
		var scrTop = 0;

		//определяем позицию скролла всех браузеров кроме гугла
		scrTop = $("html,body").scrollTop();

		//определяем позицию скролла у гугл хрома
		if(scrTop == 0)
			scrTop = $("body").scrollTop();

		// определяем сдвиг, а это высота экрана - высота изображения / 2
		scrTop += ( ($(window).height() - this.gList[this.cursor].getImg().height) / 2);

		$('.siteset-gallery-modal').css({
			'top':         scrTop + 'px',
			'width':       this.gList[this.cursor].getImg().width,
			'height':      this.gList[this.cursor].getImg().height,
			'left':        '50%',
			'margin-left': '-' + (this.gList[this.cursor].getImg().width / 2) + 'px'
		});

		// загружаем изображение
		$('.siteset-gallery-img').html(''
			+ '<img'
				+' src="' + this.gList[this.cursor].getImg().link  + '"'
				+' alt="' + this.gList[this.cursor].getImg().title + '"'
			+ '>'
		);

		// формируем заголовок
		this.getTitle();

		// формируем кнопки влево вправо
		this.getSwitch();
	};

	/**
	 * метод формирует кнопки перехода
	 *
	 */

	this.getSwitch = function() {
		var self = this;

		// если в галереи одно изображение
		if (self.gList[self.cursor].qnt == 1) {
			// прчем кнопки
			$('.siteset-gallery-switch').css('display', 'none');

			// выходим
			return;
		}

		// показываем кнопки
		$('.siteset-gallery-switch').css('display', '');
	};

	/**
	 * метод формирует заголовок
	 *
	 */

	this.getTitle = function() {
		$('.siteset-gallery-desc') .text(this.gList[this.cursor].getImg().title);

		// показываем кол-во
		$('.siteset-gallery-count').css('display', '');

		// если в галереи более одного изображения
		if (this.gList[this.cursor].qnt > 1)
			// заполняем информер
			$('.siteset-gallery-count').text(''
				+ 'фото '
				+ (this.gList[this.cursor].cursor + 1)
					+ ' из '
				+ this.gList[this.cursor].qnt)
			;

		// в противном случае
		else
			// прячем счетчик
			$('.siteset-gallery-count').css('display', 'none');
	};

	/**
	 * метод закрывает галерею
	 *
	 */

	this.close = function() {
		var self = this;

		// прячем все
		$('.siteset-gallery-modal').fadeTo(self.speed, 0, function () {
			$('.siteset-gallery-modal').css('display', '');

			$('.siteset-gallery-modal-bg').fadeTo(self.speed, 0, function () {
				$('.siteset-gallery-modal-bg').css('display', '');

				// слушаем стрелки влево и вправо
				$(window).unbind('keydown');
			});
		});
	};

	/**
	 * метод получает след изображение
	 *
	 */

	this.next = function() {
		var self = this;

		// если в галерее одно изображение
		if (self.gList[self.cursor].qnt == 1)
			// выходим, листать нечего
			return;

		// если уже происходит переход
		if ($('.siteset-gallery-modal').hasClass('siteset-gallery-busy'))
			// выходим
			return;

		// ставим флаг, позволяющий пресечь попытку
		// запустить переход второй раз
		$('.siteset-gallery-modal').addClass('siteset-gallery-busy');

		// спрятать модальное окно
		$('.siteset-gallery-modal').fadeTo(self.speed, 0, function () {
			// переключаем изображение
			self.gList[self.cursor].next();

			// загружаем
			self.load()

			// поднять модальное окно
			$('.siteset-gallery-modal').fadeTo(self.speed, 1, function() {
				// удаляем флаг
				$('.siteset-gallery-modal').removeClass('siteset-gallery-busy');
			});
		});
	};

	/**
	 * метод получает предыдущее изображение
	 *
	 */

	this.prev = function() {
		var self = this;

		// если в галерее одно изображение
		if (self.gList[self.cursor].qnt == 1)
			// выходим, листать нечего
			return;

		// если уже происходит переход
		if ($('.siteset-gallery-modal').hasClass('siteset-gallery-busy'))
			// выходим
			return;

		// ставим флаг, позволяющий пресечь попытку
		// запустить переход второй раз
		$('.siteset-gallery-modal').addClass('siteset-gallery-busy');

		// спрятать модальное окно
		$('.siteset-gallery-modal').fadeTo(self.speed, 0, function () {
			// переключаем изображение
			self.gList[self.cursor].prev();

			// загружаем
			self.load()

			// поднять модальное окно
			$('.siteset-gallery-modal').fadeTo(self.speed, 1, function() {
				// удаляем флаг
				$('.siteset-gallery-modal').removeClass('siteset-gallery-busy');
			});
		});
	};

	/**
	 * метод собирает список изображений
	 *
	 */

	this.gatherGList = function() {
		var self = this;

		$('.siteset-gallery').each(function() {
			var obj = new sitesetGalleryImg({
					'box':   $(this),
					'index': self.gList.length
				});

			if (!self.empty(obj.imgList)) {
				obj.setStack();
				self.gList.push(obj);
			}
		});
	};

	/**
	 * метод выбирает галерею
	 *
	 * @return this
	 *
	 * @param integer index - индекс галереи
	 */

	this.setIndex = function(index) {
		this.cursor = index;
		return this;
	};

	/**
	 * метод устанавливает курсор на изображение
	 *
	 * @return this
	 *
	 * @param integer cursor - индекс изображения
	 */

	this.setCursor = function(cursor) {
		this.gList[this.cursor].cursor = cursor;
		return this;
	};

	/**
	 * метод проверят переменную на пустоту
	 *
	 * @return - boolean
	 *
	 * @param ??? variable - переменная для проверки
	 */

	this.empty = function (variable) {

		if (typeof(variable) == 'object') {
			for (i in variable)
				return false;

			return true;
		}

		else if (typeof(variable) == 'number') {
			return (variable == 0) ? true : false;
		}

		else if (typeof(variable) == 'string') {
			return (variable == '' || variable == undefined) ? true : false;
		}

		return true;
	};

	// формируем верстку галереи
	this.init();

	// собираем галереи
	this.gatherGList();
}

/**
 * класс управления изображениями галереи
 *
 */

function sitesetGalleryImg(opt)
{
	/**
	 * объект галереи
	 *
	 * @var - object
	 */

	this.obj = opt.box;

	/**
	 * ключ в глобальном массиве галереи
	 *
	 * @var - intrger
	 */

	this.index = opt.index;

	/**
	 * кол-во изображений в галерее
	 *
	 * @var - integer
	 */

	this.qnt = 0;

	/**
	 * текущее положение курсора на изображении
	 *
	 * @var - integer
	 */

	this.cursor = 0;

	/**
	 * список изображений
	 *
	 * @var - array
	 */

	this.imgList = [];

	/**
	 * метод собирает список изображений
	 *
	 */

	this.gatherImgList = function() {
		var self = this;
		var img  = {};

		// если прислан не блок с списком изображений
		// а лишь одно изображение
		if (self.obj[0].tagName == 'A') {
			// если атрибут href не пуст
			if (!self.empty(self.obj.attr('href'))) {
				// создаем объект с изображением
				cursor    = self.imgList.length;

				img       = {};
				img.link  = self.obj.attr('href');
				img.title = self.obj.find('img').attr('alt');

				//self.obj.prop('href', 'javascript: void(0);');
				self.obj.bind('click', function () {
					sitesetGalleryList.setIndex(self.index).setCursor(cursor).open();
					return false;
				});

				self.imgList.push(img);
			}
		}

		// если прислан блок с изображениями
		else
			self.obj.find("a").each(function() {
				if (self.empty($(this).attr('href')))
					return;

				// создаем объект с изображением
				var cursor = self.imgList.length;

				img        = {};
				img.link   = $(this).attr('href');
				img.title  = $(this).find('img').attr('alt');

				//$(this).prop('href', 'javascript: void(0);');
				$(this).bind('click', function () {
					sitesetGalleryList.setIndex(self.index).setCursor(cursor).open();
					return false;
				});

				self.imgList.push(img);
			});

		self.qnt = self.imgList.length;
	};

	/**
	 * метод получает изображение
	 *
	 */

	this.getImg = function () {
		var self = this;

		var wW   = $(window).width()  - 100;
		var hW   = $(window).height() - 100;

		var wI   = $('.siteset-gallery-g-' + self.index + '-' + self.cursor).width();
		var hI   = $('.siteset-gallery-g-' + self.index + '-' + self.cursor).height();

		// уравниваем изображение по экрану
		while (true) {
			// если изображение не впределах окна
			if (wW < wI || hW < hI) {
				// определяем что вышло за экран
				// если ширина картинки вышла за экран
				if (wW < wI) {
					// определяем новую высоту
					hI = wW / (wI / hI);
					// заполняем ширину
					wI = wW;
				}

				// значит за основу берем высоту
				else {
					// расчитываем ширину
					wI = hW / (hI / wI);
					// заполняем высоту
					hI = hW;
				}
			}
			else
				break;
		}

		return {
			'width':    wI,
			'height':   hI,
			'link':     self.imgList[self.cursor].link,
			'title':    self.imgList[self.cursor].title,
			'position': self.cursor + 1
		};
	};

	/**
	 * метод выберает следующее изображение
	 *
	 */

	this.next = function () {
		var self = this;

		if (!self.empty(self.imgList[(self.cursor + 1)]))
			self.cursor = self.cursor + 1;
		else
			self.cursor = 0;
	};

	/**
	 * метод выбирает предыдущее изображение
	 *
	 */

	this.prev = function () {
		var self = this;

		if (!self.empty(self.imgList[(self.cursor - 1)]))
			self.cursor = self.cursor - 1;
		else
			self.cursor = self.imgList.length - 1;
	};

	/**
	 * метод заполняет стек изображений
	 *
	 */

	this.setStack = function () {
		var self = this;

		// листаем изображения
		for (i in self.imgList)
			$('.siteset-gallery-loader').append(''
				+ '<img'
					+ ' class="siteset-gallery-g-' + self.index + '-' + i + '"'
					+ ' src="' + self.imgList[i].link  + '"'
					+ ' alt="' + self.imgList[i].title + '"'
				+'>'
			);
	};

	/**
	 * метод проверят переменную на пустоту
	 *
	 * @return - boolean
	 *
	 * @param ??? variable - переменная для проверки
	 */

	this.empty = function (variable) {

		if (typeof(variable) == 'object') {
			for (i in variable)
				return false;

			return true;
		}

		else if (typeof(variable) == 'number') {
			return (variable == 0) ? true : false;
		}

		else if (typeof(variable) == 'string') {
			return (variable == '' || variable == undefined) ? true : false;
		}

		return true;
	};

	// собираем изображения
	this.gatherImgList();
}