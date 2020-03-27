/**
 *
 * @version 0.1
 */

/**
 * вызов sitesetFilebrowse
 *
 * @return sitesetFilebrowse
 */

function ssFB(input, opt)
{
	if (undefined === opt)
		opt = {};

	return new sitesetFilebrowse(input, opt);
}

/**
 *
 */

function sitesetFilebrowse(field, opt)
{
	/**
	 *
	 *
	 */

	this.field = field;

	/**
	 *
	 *
	 */

	this.browse = opt.browse;

	/**
	 *
	 *
	 */

	this.rebrowse = opt.rebrowse;

	/**
	 *
	 *
	 */

	this.clear = opt.clear;

	/**
	 *
	 *
	 *
	 */

	this.init = function () {
		$("*").each(function () {
			if (undefined === $(this).attr('data-custom-filebrowse'))
				return;

			if (self.field !== $(this).attr('data-custom-filebrowse'))
				return;

			// центральный блок
			var box = $(this);

			// реакция на клик по кнопке загрузка
			box.find(self.browse).bind('click', function () {
				box.find("input[type='file']").trigger('click');
			});

			// реакция на клик по кнопке перезагрузка
			box.find(self.rebrowse).bind('click', function () {
				box.find("input[type='file']").trigger('click');
			});

			// реакция на клик по кнопке чистка
			box.find(self.clear).bind('click', function () {
				self.cleared(box);
			});

			// реакция на выбор файла
			box.find("input[type='file']").bind('change', function (event) {
				self.done(box, $(event.target));
			});

		});
	};

	/**
	 *
	 *
	 *
	 */

	this.cleared = function (box) {
		var attributes = [];

		// удаляем кнопку перезагрузки
		box.find(self.rebrowse).addClass('hidden');

		// показываем кнопку загрузки
		box.find(self.browse).removeClass('hidden');

		// блокируем кнопку чистки
		box.find(self.clear).addClass('hidden');

		// пересоздаем инпут
		for (index in box.find("input[type='file']")[0].attributes) {
			if (undefined === box.find("input[type='file']")[0].attributes[index].name)
				continue;

			if (undefined === box.find("input[type='file']")[0].attributes[index].value)
				continue;

			attributes.push(''
				+ box.find("input[type='file']")[0].attributes[index].name
				+ '='
				+ '"' + box.find("input[type='file']")[0].attributes[index].value + '"'
			);
		}

		box.find("input[type='file']").replaceWith(''
			+ '<input'
				+ ( (attributes.length > 0) ? ' ' + attributes.join(' ') : '' )
			+ '>'
		);

		// восстанавливаем реакцию на выбор файла
		box.find("input[type='file']").bind('change', function (event) {
			self.done(box, $(event.target));
		});
	};

	/**
	 *
	 *
	 *
	 */

	this.done = function (box, input) {
		// получаем имя файла
		var arr		= input.val().split('\\');
		var name	= arr[arr.length - 1];

		// прячем кнопку browse
		box.find(self.browse).addClass('hidden');

		// формируем имя кнопки перезагрузки
		box.find(self.rebrowse).find('span').text(name);

		// активируем кнопку перезагрузки
		box.find(self.rebrowse).removeClass('hidden');

		// активируем кнопку чистки
		box.find(self.clear).removeClass('hidden');
	};

	var self = this;
}