/**
 *
 * @version 0.1
 */

/**
 * вызов sitesetCheckboxgroup
 *
 * @return sitesetCheckboxgroup
 */

function ssCheckbox(field, callbacks)
{
	return new sitesetCheckboxgroup(field, callbacks);
}

/**
 *
 */

function sitesetCheckboxgroup(field, callbacks)
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

	this.callbacks = callbacks;

	/**
	 *
	 *
	 *
	 */

	this.init = function () {
		$("*").each(function () {
			if (undefined === $(this).attr('data-checkboxgroup'))
				return;

			// центральный блок
			var box = $(this);

			box.find("input[type='checkbox']").each(function (i) {
				$(this).bind('change', function () {
					self.activated(box, $(this), i);
				});
			});
		});
	};

	/**
	 *
	 *
	 *
	 */

	this.activated = function (box, input, index) {
		// сбрасываем все чеки
		box.find("input[type='checkbox']").each(function (i) {
			var active = $(this).prop('checked');

			// пропускаем обработку выбраного чекбокса
			if (index === i)
				return;

			// деактивируем чекбокс
			$(this).prop('checked', false);

			// если чекбокс был активный
			if (true === active)
				// запускаем колбак на диактивацию
				// чекбокса
				if (
						undefined !== self.callbacks[i]
					&&	undefined !== self.callbacks[i].deactivated
				)
					self.callbacks[i].deactivated(box, $(this));
		});

		// запускаем триггер
		if (false === input.prop('checked'))
			if (
					undefined !== self.callbacks[index]
				&&	undefined !== self.callbacks[index].deactivated
			)
				self.callbacks[index].deactivated(box, input);

		if (true === input.prop('checked'))
			if (
					undefined !== self.callbacks[index]
				&&	undefined !== self.callbacks[index].activated
			)
				self.callbacks[index].activated(box, input);
	};

	var self = this;
}