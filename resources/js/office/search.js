/**
 * класс живой поиск. пример использования:
 *
 * $(document).ready(function() {
 *     // инициализируем поиск
 *     var search = new ssSearch({
 *         obj:        '#search-form',      // устанавливаем блок с поисковой формой
 *         ajaxPath:   '/search/',          // путь к странице с аякс скриптом
 *         mc:         300,                 // милисекунды до закрытия списка поиска
 *         notFound:   'Ничего не найдено', // текст ошибки
 *         token:      '123456'             // токен csrf
 *     });
 *
 *     search.init();
 * });
 *
 * @version 1.5
 */

function ssSearch(opt) {

	/**
	 * свойство хранит задержку в мс
	 * @var - integer
	 */

	this.ms = (opt.mc != undefined) ? opt.mc : 300;

	/**
	 * свойство хранит объект jq
	 * @var - object
	 */

	this.obj = $(opt.obj);

	/**
	 * свойство хранит номер страницы для
	 * ленивой загрузки
	 *
	 * @var - integer
	 */

	this.page = 1;

	/**
	 * свойство хранит сдвиг точки срабатывания
	 * ленивой загрузки
	 *
	 * @var - integer
	 */

	this.shift = 0;

	/**
	 * свойство хранит путь к ajax скрипту
	 * @var - string
	 */

	this.ajaxPath = opt.ajaxPath;

	/**
	 * свойство хранит токен token
	 * @var - string
	 */

	this.token = opt.token;

	/**
	 * свойство хранит текст ошибки
	 * @var - string
	 */

	this.notFound = (opt.notFound != undefined) ? opt.notFound : 'Ничего не найдено';

	/**
	 * свойство хранит набранный текст в инпут
	 * @var - string
	 */

	this.keyBoard = '.ss-search-keyboard-name';

	/**
	 * свойство хранит селкетор инпута поисковой
	 * строки
	 * @var - string
	 */

	this.inputSearch = '.ss-search-field';

	/**
	 * свойство хранит селкетор инпута с выводом
	 * выбранного результата
	 * @var - string
	 */

	this.inputResult = '.ss-search-select-result';

	/**
	 * свойство хранит селкетор блока
	 * списка
	 * @var - string
	 */

	this.listBox = '.ss-search-list-box';

	/**
	 * свойство хранит селкетор списка
	 * @var - string
	 */

	this.list = '.ss-search-list';

	/**
	 * свойство хранит селкетор деселекта
	 * @var - string
	 */

	this.deSelect = '.ss-search-deselect';

	/**
	 * свойство хранит селкетор кнопки создания нового
	 * документа
	 * @var - string
	 */

	this.create = '.ss-search-create';

	/**
	 * свойство хранит имя поля
	 * @var - string|null
	 */

	this.field = (opt.field != undefined) ? opt.field : null;

	/**
	 * свойство хранит список полей
	 * для пост запроса
	 * @var - object
	 */

	this.fields = {};

	/**
	 * метод инициализирует форму
	 *
	 */

	this.init = function() {
		var self = this;

		// события на нажатие интера
		ssEnter().reg(
			function (e) {
				var id = $(e.target).attr('id');

				if ($('#' + id).parent().css('display') == 'none')
					return false;

				return $(e.target).hasClass('ss-search-field');
			},
			'ss-search',
			100
		);

		// события на переключатель
		self.obj.find(self.inputResult).bind('focus', function() {
			self.toggle();
		});

		// события на клик по деселекту
		self.obj.find(self.deSelect).bind('click', function() {
			self.obj.find(self.inputResult).val('');
			self.obj.find("input[type='hidden']").val('');
			self.obj.find("input[id$='_enter']").val('');

			self.obj.trigger('ssSearchDeSelect');
		});

		// событие скролла
		self.obj.find(self.list).scroll(function() {
			self.lazyLoading();
		});

		// ловим клавишу
		self.obj.find(self.inputSearch).bind('input keydown', function(e) {
			self.run(e);
		});

		// убираем окно при потере фокуса
		self.obj.find(self.inputSearch).blur(function() {
			setTimeout(function() {
				self.close();
			}, self.ms);
		});

		// навели мышь на бокс
		self.obj.find(self.listBox).bind('mouseover', function() {
			self.overBox();
		});

		// убрали мышь с бокса
		self.obj.find(self.listBox).bind('mouseout', function() {
			self.outBox();
		});

		self.addBusy();
		self.obj.find(self.list).scrollTop(0);
		setTimeout(function() {
			self.load();
		}, self.ms);
	};

	/**
	 * метод запускает событие по нажатию клавиши
	 *
	 * @return - boolean
	 *
	 * @param object e - объект события
	 */

	this.run = function(e) {
		var self = this;
		var code = e.keyCode;

		// incorrect symbols
		if (
				 (code != 8)
			  && (code != 13)
			  && (code != 27)
			  && (code != 32)
			  && (code != 38)
			  && (code != 40)
			  && (code != 46)
			  && ((code < 48)  || (code > 90))
			  && ((code > 111) || (code < 96))
			  && ((code < 186) || (code > 192))
			  && (code != 220)
			  && (code != 222)
		  )
			return false;

		//  стрелка вверх
		if (code == 38) {
			self.up();
			return true;
		}

		// стрелка вниз
		if (code == 40) {
			self.down();
			return true;
		}

		// интер
		if (code == 13) {

			// если событие выбора пункта из списка
			if (ssEnter().can(e, 'ss-search'))
				// производим обработку нажатия клавиши
				// интер
				self.enter();

			return true;
		}

		// ескейпт
		if (code == 27) {
			self.close();
			return true;
		}

		self.reLoad();

		return true;
	};

	/**
	 * перезагрузка списка
	 *
	 */

	this.reLoad = function() {
		var self = this;

		if (!self.hasBusy()) {
			self.obj.find(self.list).scrollTop(0);
			self.obj.find(self.list + ' ul').html('');
			self.page  = 1;
			self.shift = 0;
			self.addBusy();
			setTimeout(function() {
				self.load();
			}, self.ms);
		}
	}

	/**
	 * метод отрабатывает событие клавиши интер
	 *
	 */

	this.enter = function() {
		var self = this;
		var getName = function () {
			// если есть активный пункт
			if (self.obj.find(self.list + ' ul li.active').length > 0)
				return self.obj.find(self.list + ' ul li.active .ss-search-ajax-text').text();

			// если активного пункта нет, но список состоит из одного
			// пункта
			if (
				   self.obj.find(self.list + ' ul li').length == 1
				&& self.obj.find(self.list + ' ul li .ss-search-ajax-text').length == 1
			)
				return self.obj.find(self.list + ' ul li .ss-search-ajax-text').text();

			return self.obj.find(self.keyBoard).text();
		};

		var getID = function () {
			// если есть активный пункт
			if (self.obj.find(self.list + ' ul li.active').length > 0)
				return self.obj.find(self.list + ' ul li.active .ss-search-ajax-id').text();

			// если активного пункта нет, но список состоит из одного
			// пункта
			if (
				   self.obj.find(self.list + ' ul li').length == 1
				&& self.obj.find(self.list + ' ul li .ss-search-ajax-id').length == 1
			)
				return self.obj.find(self.list + ' ul li .ss-search-ajax-id').text();

			return 0;
		};

		var name = getName();
		var id   = getID();

		self.toggle();

		self.obj.find(self.inputResult).val((id > 0) ? name : '');
		self.obj.find("input[type='hidden']").val(id);

		self.obj.trigger('ssSearchEnter');
	};

	/**
	 * метод отрабатывает событие клавиши вверх
	 * @return - boolean
	 *
	 */

	this.up = function() {
		var self  = this;
		var count = self.obj.find(self.list + ' ul li').length;
		var name;

		if (self.obj.find(self.list + ' ul').text() == '' || self.obj.find(self.list + ' ul li.ss-search-notfound').length > 0)
			return false;

		if (self.obj.find(self.list + ' ul li.active').length == 0)
			self.obj.find(self.list + ' ul li:eq(' + (count - 1) + ')').addClass('active');

		else
			self.obj.find(self.list + ' ul li.active').removeClass('active').prev().addClass('active');

		self.scroll();

		self.obj.trigger('ssSearchUp');

		return true;
	};

	/**
	 * метод отрабатывает событие клавиши вниз
	 *
	 */

	this.down = function() {
		var self = this;
		var name;

		if (self.obj.find(self.list + ' ul li.ss-search-notfound').length > 0)
			return false;

		if (self.obj.find(self.list + ' ul li.active').length == 0)
			self.obj.find(self.list + ' ul li:eq(0)').addClass('active');

		else
			self.obj.find(self.list + ' ul li.active').removeClass('active').next().addClass('active');

		self.scroll();

		self.obj.trigger('ssSearchDown');

		return true;
	};

	/**
	 * метод отрабатывает событие "навели мышь" на пункт
	 *
	 * @param object obj - объект jq (li)
	 */

	this.overPoint = function(obj) {
		var self = this;

		if (!obj.hasClass('ss-search-notfound')) {
			self.obj.find(self.list + ' ul li').removeClass('active');
			obj.addClass('active');
		}

		self.obj.trigger('ssSearchOverPoint');
	};

	/**
	 * метод отрабатывает событие "навели мышь" на бокс
	 *
	 * @param object obj - объект jq
	 */

	this.overBox = function(obj) {
		var self = this;
		self.obj.find(self.listBox).addClass('ss-search-box-over');

		self.obj.trigger('ssSearchOverBox');
	};

	/**
	 * метод отрабатывает событие "убрали мышь" с бокс
	 *
	 * @param object obj - объект jq
	 */

	this.outBox = function(obj) {
		var self = this;
		self.obj.find(self.listBox).removeClass('ss-search-box-over');

		self.obj.trigger('ssSearchOutBox');
	};

	/**
	 * метод запускает загрузку
	 * @return - boolean
	 *
	 */

	this.load = function() {
		var self  = this;

		var value = self.obj.find(self.inputSearch).val();
		self.obj.find(self.keyBoard).text(value);
		self.obj.find(self.list + ' ul li').unbind('click');
		self.obj.find(self.list + ' ul li').unbind('mouseover');
		self.unDisabled();

		// собираем поля для запроса
		self.fields['_token']	= self.token;
		self.fields['value']	= value;
		self.fields['page']		= self.page;
		self.fields['field']	= self.field;

		self.obj.trigger('ssSearchLoad');

		$.post(self.ajaxPath, self.fields, function(data) {
			var str = '';

			// если есть данные
			if (data.length > 0)
				for(index in data) {
					str =  "<li>";
						for(field in data[index]) {
							if (field == 'value')
								str += "<span class='ss-search-ajax-text'>" + data[index].value + "</span>"
							else
								str += "<span class='ss-search-ajax-" + field + " hidden'>" + data[index][field] + "</span>"
						}
					str += "</li>";

					self.obj.find(self.list + ' ul').append(str);
				}

			// если их нет
			else {
				// если поисковый запрос был пуст
				// и страница 1
				if ('' == value && self.page == 1)
					self.disabled();

				self.page = -1;

				// если нет пункта "ничего не найдено"
				if (self.obj.find(self.list + ' ul li').length == 0)
					self.obj.find(self.list + ' ul').html("<li class='ss-search-notfound'>" + self.notFound + "</li>");
			}

			// событие клика на выбранный пункт
			self.obj.find(self.list + ' ul li').bind('click', function() {
				self.enter();
			});

			// событие наведение мыши на пункт
			self.obj.find(self.list + ' ul li').bind('mouseover', function() {
				self.overPoint($(this));
			});

			// расчет высоты и позиции списка
			self.position();

			self.obj.trigger('ssSearchLoaded', [data]);

			self.removeBusy();
		}, 'json');

		return true;
	};

	/**
	 * переключатель состояния живого
	 * поиска
	 *
	 */

	this.toggle = function () {
		var self = this;

		self.obj.find(self.inputResult).blur();

		if (self.obj.find(self.listBox).css('display') == 'none') {
			self.obj.find(self.listBox).css('display', 'block');
			self.obj.find(self.inputSearch).focus();
			self.position();
		}
		else {
			self.obj.find(self.listBox).css('display', 'none');
			self.obj.find(self.inputSearch).blur();
		}
	};

	/**
	 * метод закрывает результат поиска
	 *
	 */

	this.close = function() {
		var self = this;

		if (
			   self.obj.find(self.listBox).css('display') != 'none'
			&& !self.obj.find(self.listBox).hasClass('ss-search-box-over')
		)
			self.toggle();
	};

	/**
	 * метод запускает ленивую
	 * загрузку
	 *
	 */

	this.lazyLoading = function() {
		var self   = this;
		var height = self.obj.find(self.list + ' ul').innerHeight();
		var top    = self.obj.find(self.list).scrollTop() + (self.obj.find(self.list).innerHeight() / 2);

		if (self.page >= 1)
			if (
				top
				>
				self.shift + ((height - self.shift) / 2)
			) {
				++self.page;
				self.shift = height;
				self.load();
			}

		self.obj.find(self.inputSearch).focus();
	};

	/**
	 * метод сдвигает скролл
	 *
	 */

	this.scroll = function() {
		var self   = this;
		var win    = [
			self.obj.find(self.list).scrollTop(),
			self.obj.find(self.list).scrollTop() + self.obj.find(self.list).innerHeight()
		];

		if (self.obj.find(self.list + ' ul li.active').length == 0)
			return;

		var posTop    = function () {
			var h = 0
				+ self.obj.find(self.list + ' ul li.active').offset().top
				- self.obj.find(self.list + ' ul').offset().top
			;

			return parseInt(h);
		};
		var posBottom = function () {
			var h = 0
				+ self.obj.find(self.list + ' ul li.active').offset().top
				- self.obj.find(self.list + ' ul').offset().top
				+ self.obj.find(self.list + ' ul li.active').innerHeight()
			;

			return parseInt(h);
		};

		// определяем находится ли пункт в области видимости

		// если нет и пункт ушел вверх
		if (posTop() < win[0] && posBottom() <= win[0])
			self.obj.find(self.list).scrollTop(
				posTop()
			);

		// если нет и пункт ушел вниз
		if (posTop() >= win[1] && posBottom() > win[1]) {
			self.obj.find(self.list).scrollTop(
				posBottom() - self.obj.find(self.list).innerHeight()
			);
		}
	};

	/**
	 * метод определяет позицию и высоту окна
	 *
	 */

	this.position = function() {
		var self = this;
		var getH = function () {
			var h = 0;

			self.obj.find(self.list + ' ul li').each(function (i) {
				if (i >= 10)
					return false;

				h += $(this).innerHeight();
			});

			return h;
		};

		// сбрасываем высоты
		self.obj.find(self.list + ' ul li').css({
			'height': 'auto'
		});

		// округляем
		self.obj.find(self.list + ' ul li').each(function () {
			$(this).css({
				'height': parseInt($(this).innerHeight())
			});
		});

		self.obj.find(self.list).css({
			'height': getH()
		});
	};

	/**
	 * блокирует поисковую
	 * строку
	 *
	 */

	this.disabled = function() {
		var self		= this;
		var getBlock	= function (btn) {
			var html	= $('<div></div>');
			html.addClass('ss-search-disabled');
			html.css({
				width:		(btn.innerWidth() + 1)	+ 'px',
				height:		(btn.innerHeight() + 3)	+ 'px',
				position:	'absolute'
			});

			return html;
		}

		// блокируем отображалку выбраного пункта
		self.obj.find(self.inputResult).attr('disabled', true);

		// блокируем кнопки
		self.obj.find(self.deSelect).before(
			getBlock(self.obj.find(self.deSelect))
		);

		//self.obj.find(self.create).before(
		//	getBlock(self.obj.find(self.create))
		//);
	};

	/**
	 * разблокирует поисковую
	 * строку
	 *
	 */

	this.unDisabled = function() {
		var self = this;

		// разблок поисковой строки
		self.obj.find(self.inputResult).attr('disabled', false);

		// удаление заглушек
		self.obj.find('.ss-search-disabled').remove();
	};

	/**
	 * позволяет передать в пост запрос
	 * доп поля
	 *
	 * @param string	field
	 * @param mixed		value
	 */

	this.addField = function(field, value) {
		this.fields[field] = value;
		return this;
	};

	/**
	 * метод ставит отметку о том что идет поиск
	 *
	 */

	this.addBusy = function() {
		this.obj.find(this.inputSearch).addClass('ss-search-busy');
	};

	/**
	 * метод удаляет отметку о том что идет поиск
	 *
	 */

	this.removeBusy = function() {
		this.obj.find(this.inputSearch).removeClass('ss-search-busy');
	};

	/**
	 * метод определяет идет ли поиск
	 * @return - boolean
	 *
	 */

	this.hasBusy = function() {
		return this.obj.find(this.inputSearch).hasClass('ss-search-busy');
	};
}