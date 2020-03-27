/**
 *
 *
 *
 *
 */

function ssWin()
{
	/**
	 * список окон
	 *
	 * @var array
	 */

	this.winList = [];

	/**
	 * превикс окон
	 *
	 * @var string
	 */

	this.prefix = '.win';

	/**
	 * метод сохраняет в стек имя окна
	 *
	 * @param array winList список окн
	 */

	this.init = function (winList) {
		self.winList = winList;

		for (i = 0; self.winList[i]; i++) {
			$(self.prefix + '-' + self.winList[i]).addClass('ss-win-close');
			self.resize(self.winList[i]);
		}
	};

	/**
	 * метод переключает окна
	 *
	 * @param string win имя окна
	 * @param function callback коллбак функция
	 */

	this.toggle = function (win, callback) {
		for (i = 0; self.winList[i]; i++)
			if (self.winList[i] != win && self.isOpened(self.winList[i]))
				self.close(self.winList[i]);

		var id = setInterval(function () {
			if (!$('*').hasClass('ss-win-busy')) {
				if (self.isClosed(win))
					self.open(win);

				else
					self.close(win);

				// если существует коллбак функция
				if (callback != undefined)
					// исполняем ее
					callback();

				clearInterval(id);
			}
		}, 1);
	};

	/**
	 * метод закрывает окно
	 *
	 * @param string win имя окна
	 */

	this.close = function (win) {

		$(self.prefix + '-' + win).trigger('ssWinClose', [$(self.prefix + '-' + win)]);

		if (!$(self.prefix + '-' + win).hasClass('ss-win-instead-close'))
			$(self.prefix + '-' + win).css({
				'display': 'none'
			});

		else
			$(self.prefix + '-' + win).trigger('ssWinInsteadClose', [$(self.prefix + '-' + win)]);

		$(self.prefix + '-' + win).trigger('ssWinClosed', [$(self.prefix + '-' + win)]);

		$(self.prefix + '-' + win).removeClass('ss-win-open');
		$(self.prefix + '-' + win).addClass('ss-win-close');
	};

	/**
	 * метод открывает окно
	 *
	 * @param string win имя окна
	 */

	this.open = function (win) {

		$(self.prefix + '-' + win).trigger('ssWinOpen', [$(self.prefix + '-' + win)]);

		if (!$(self.prefix + '-' + win).hasClass('ss-win-instead-open'))
			$(self.prefix + '-' + win).css({
				'display': 'block'
			});

		else
			$(self.prefix + '-' + win).trigger('ssWinInsteadOpen', [$(self.prefix + '-' + win)]);

		$(self.prefix + '-' + win).trigger('ssWinOpened', [$(self.prefix + '-' + win)]);

		$(self.prefix + '-' + win).removeClass('ss-win-close');
		$(self.prefix + '-' + win).addClass('ss-win-open');
	};

	/**
	 * событие ресайза
	 *
	 * @param string win имя окна
	 */

	this.resize = function (win) {
		$(window).resize(function() {
			$(self.prefix + '-' + win).trigger('ssWinResize', [$(self.prefix + '-' + win)]);
		});
	};

	/**
	 * метод биндит обработчик
	 * события
	 *
	 * @param string win имя окна
	 * @param string event событие
	 * @param func hendler обработчик
	 */

	this.trigger = function (win, event, hendler) {

		switch (event) {
			case 'ssWinInsteadOpen':
				$(self.prefix + '-' + win).addClass('ss-win-instead-open');
				break;

			case 'ssWinInsteadClose':
				$(self.prefix + '-' + win).addClass('ss-win-instead-close');
				break;
		}

		$(self.prefix + '-' + win).bind(event, hendler);

		return this;
	};

	/**
	 * метод добавляет новое окно
	 *
	 * @return ssWin
	 *
	 * @param string win имя окна
	 */

	this.newWin = function (win) {
		var found = false;

		for (i in self.winList)
			if (self.winList[i] == win) {
				found = true;
				break;
			}

		if (!found) {
			$(self.prefix + '-' + win).addClass('ss-win-close');
			self.winList.push(win);
			self.resize(win);
		}

		return this;
	};

	/**
	 * метод сохраняет префикс окна
	 *
	 * @return ssWin
	 *
	 * @param string prefix префикс окна
	 */

	this.setPrefix = function (prefix) {

		self.prefix = '.' + prefix;

		return this;
	};

	/**
	 * открыто ли окно
	 *
	 * @return boolean
	 *
	 * @param string win имя окна
	 */

	this.isOpened = function (win) {
		return $(self.prefix + '-' + win).hasClass('ss-win-open');
	};

	/**
	 * закрыто ли окно
	 *
	 * @return boolean
	 *
	 * @param string win имя окна
	 */

	this.isClosed = function (win) {
		return $(self.prefix + '-' + win).hasClass('ss-win-close');
	};

	/**
	 * глоб переменная
	 *
	 */

	var self = this;
}

var win = new ssWin();
