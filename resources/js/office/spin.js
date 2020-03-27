/**
 * переменная для хранения объекта
 * sitesetSpin
 *
 * @var sitesetSpin
 */

var ssSpinVariable = null;

/**
 * вызов sitesetSpin в виде
 * синглтона
 *
 * @return sitesetSpin
 */

function ssSpin()
{
	if (ssSpinVariable == null)
		ssSpinVariable = new sitesetSpin();

	return ssSpinVariable;
}

/**
 * класс
 *
 */

function sitesetSpin()
{
	/**
	 * префикс блоков
	 *
	 * @var string
	 */

	this.box = 'modal';

	/**
	 * удалять ли фон
	 *
	 * @var boolean
	 */

	this.dontdelete = false;

	/**
	 * активен ли спин
	 *
	 * @var boolean
	 */

	this.active = false;

	/**
	 *
	 *
	 */

	this.show = function (fn) {

		if (true === self.active)
			return;

		self.active = true;

		// если БГ уже есть
		if (
				$('body').find('.' + self.box + '-backdrop').length > 0
			&&	$('body').hasClass(self.box + '-open')
		) {
			// помещаем БГ на передний план
			$('body').find('.' + self.box + '-backdrop').addClass('ss-spin-z-index');

			// говорим скрипту не удалять его
			self.dontdelete = true;

			// открываем изображение
			$('body').find('.' + self.box + '-backdrop').before('<div class="ss-spin-gif"></div>');

			if (undefined !== fn)
				fn();
		}

		// если нет БГ
		else {
			// вставляем БГ
			$('body').append('<div class="' + self.box + '-backdrop fade"></div>');

			// помещаем его на передний план
			$('body').find('.' + self.box + '-backdrop').addClass('ss-spin-z-index');

			// убираем скролл
			$('body').addClass(self.box + '-open');

			// показываем БГ
			$('.' + self.box + '-backdrop').fadeTo(150, 0.5, function () {
				// открываем изображение
				$('body').find('.' + self.box + '-backdrop').before('<div class="ss-spin-gif"></div>');

				if (undefined !== fn)
					fn();
			});
		}
	};

	/**
	 *
	 *
	 */

	this.hide = function (fn) {

		if (false === self.active)
			return;

		self.active = false;

		// если БГ НЕ нужно удалять
		if (true === self.dontdelete) {

			// удаляем анимацию
			$('body').find('.ss-spin-gif').remove()

			// убираем с переднего плана
			$('body').find('.' + self.box + '-backdrop').removeClass('ss-spin-z-index');

			self.dontdelete = false;

			if (undefined !== fn)
				fn();
		}

		// если БГ нужно удалять
		else {
			// удаляем анимацию
			$('body').find('.ss-spin-gif').remove()

			// прячем БГ
			$('.' + self.box + '-backdrop').fadeTo(150, 0, function () {

				// удаляем БГ
				$('.' + self.box + '-backdrop').remove();

				// показываем скролл
				$('body').removeClass(self.box + '-open');

				if (undefined !== fn)
					fn();
			});
		}

	};

	/**
	 * глобальная переменнна с
	 * объектом
	 *
	 * @var sitesetSpin
	 */

	var self = this;
}