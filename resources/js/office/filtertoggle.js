/**
 * переменная для хранения объекта
 * ssFilterToggleClass
 *
 * @var ssFilterToggleClass
 */

var ssFilterToggleVariable = null;

/**
 * вызов ssFilterToggleClass в виде
 * синглтона
 *
 * @return ssFilterToggleClass
 *
 * @param string id
 */

function ssFilterToggle()
{
	if (ssFilterToggleVariable == null)
		ssFilterToggleVariable = new ssFilterToggleClass();

	return ssFilterToggleVariable;
}

/**
 *
 */

function ssFilterToggleClass()
{
	/**
	 *
	 *
	 */

	this.init = function () {
		$("*[data-ss-filter-toggle]").each(function () {
			$(this).bind('click', function (e) {
				ssFilterToggle().toggle(e);
			});

			$(this).trigger('ss-filter-toggle-inited');
		});
	};

	/**
	 *
	 *
	 */

	this.toggle = function (event) {

		var btn = $(event.target);
		var box = $(btn.attr('data-ss-filter-toggle'));

		// если открыт
		if (!box.hasClass('hidden')) {
			btn.removeClass('btn-filter');
			btn.find('i').removeClass('fa-caret-up').addClass('fa-caret-down');
			box.addClass('hidden');

			btn.trigger('ss-filter-toggle-closed');
		}

		// если закрыт
		else {
			btn.addClass('btn-filter');
			btn.find('i').removeClass('fa-caret-down').addClass('fa-caret-up');
			box.removeClass('hidden');

			btn.trigger('ss-filter-toggle-opened');
		}
	};

	/**
	 * глобальная переменная
	 *
	 * @var ssFilterToggleClass
	 */

	var self = this;
}

$(document).ready(function () {
	ssFilterToggle().init();
});